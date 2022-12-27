<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\User;
use App\Repository\CustomerRepository;
use App\Services\CustomerService;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;


class CustomerController extends AbstractController
{
    public function __construct(
        private readonly CustomerService $customerService,
        private readonly CustomerRepository $customerRepository,
        private readonly EntityManagerInterface $em,
        private readonly TagAwareCacheInterface $cache,
        private readonly SerializerInterface    $serializer,
    )
    {
    }

//Cette méthode permet de récupérer l'ensemble des clients.
    #[Route('/api/customers', name: 'customers', methods: ['GET'])]
    public function getAllCustomers(SerializerInterface $serializer, Request $request): JsonResponse
    {

        // dans customerData = je vais récupérer dans mon customerService
        $customerData = $this->customerService->cache($request);
        //pr passer une entity en json, j'ai besoin de la serializé
        //, mon entity Customers
        //n'a pas besoin de l'entity users pour éviter des références circulaire (pas de boucle)
        $context = SerializationContext::create()->setGroups(['getCustomers']);
        // besoin de transformer entity Customers en string (json)
        $json = $serializer->serialize($customerData, 'json', $context);
        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    //Cette méthode permet de récupérer un customer en particulier en fonction de son id.
    #[Route('/api/customers/{id}', name: 'detail_customers', methods: ['GET'])]
    public function getOneCustomers(Request $request, SerializerInterface $serializer)
    {
        // récupérer id qui est sur la route {id}
        $id = $request->get('id');
        //chercher la méthode find qui est ds le customerRepo
        $customerData = $this->customerRepository->find($id);
        //pr passer une entity en json, j'ai besoin de serializer
        //, mon entity Customers
        //n'a pas besoin de l'entity users pour éviter des références circulaire (pas de boucle)
        $context = SerializationContext::create()->setGroups(['getCustomers']);
        // besoin de transformer entity Customers en string (json)
        $json = $serializer->serialize($customerData, 'json', $context);

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }
//Cette méthode permet d'insérer un nouveau client.
    /**
     * @throws InvalidArgumentException
     */
    #[Route('/api/customers', name: 'createCustomer', methods: ['POST'])]
    public function createCustomer(Request $request, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        $customer = $serializer->deserialize($request->getContent(), Customer::class, 'json');

        // On vérifie les erreurs
        $errors = $validator->validate($customer);
        if ($errors->count() > 0) {
            return new JsonResponse($serializer->serialize($errors, 'json'), Response::HTTP_BAD_REQUEST, [], true);
            //throw new HttpException(JsonResponse::HTTP_BAD_REQUEST, "La requête est invalide");
        }
        $user = $this->getUser();
        $this->cache->invalidateTags(["customerCache"]);
        $customer = $this->serializer->deserialize(
            $request->getContent(), Customer::class, 'json'
        );

//        dd($customer);
        $this->em->persist($customer);
        $this->em->flush();
        $this->verifyCustomer($customer);
//        dd($customer);
        $customer->setUser($user);
dd($customer);

        return new JsonResponse($customer, Response::HTTP_CREATED);
    }
    private function verifyCustomer($customer): bool
    {
        //Il y a  pas de user ds la bdd avec email que tu reçois de la requête tu renvoie true
        if (!$this->customerRepository->findOneBy(['email' => $customer->getEmail()])) {
//            dd('c\'est bon');
            return true;
        }
        // par défaut tu renvoie false
//        dd('c\'est pas bon');
        return false;
    }

}