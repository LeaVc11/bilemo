<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
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
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;


class CustomerController extends AbstractController
{
    public function __construct(
        private readonly CustomerRepository $customerRepository,
        private readonly EntityManagerInterface $em,
        private readonly TagAwareCacheInterface $cache,
        private readonly SerializerInterface    $serializer,
    )
    {
    }

//Cette méthode permet de récupérer l'ensemble des clients.

    /**
     * @throws InvalidArgumentException
     */
    #[Route('/api/customers', name: 'customers', methods: ['GET'])]
    public function getAllCustomers(SerializerInterface $serializer, CustomerRepository $customerRepository, TagAwareCacheInterface $cache, Request $request): JsonResponse
    {
        //chercher sur la route une page avec un numéro
        // avec une valeur par défaut
        //
        $page = (int)$request->get(key: 'page', default: 1);
        //chercher sur la route avec une limit avec un numéro
        //avec une valeur par défaut
        $limit = (int)$request->get(key: 'limit', default: 3);
        //j’ai créé ici un identifiant
        //Il est construit ici avec le mot getAllCustomers
        $idCache = "getAllCustomers-" . $page . "-" . $limit;
        $customerList = $cache->get($idCache,
            function (ItemInterface $item) use ($customerRepository, $page, $limit, $serializer) {
                echo("customer");
                $item->tag("customersCache");
                // Une méthode qui est dans le customerRepo et qui envoie un tableau d'objets
                // Avec 2 paramètres page et limit
                $customers = $customerRepository->findAllWithPagination($page, $limit, $this->getUser());
                //pr passer une entity en json, j'ai besoin de la serializé
                //, mon entity Customers
                //n'a pas besoin de l'entity users pour éviter des références circulaire (pas de boucle)
                $context = SerializationContext::create()->setGroups(['getCustomers']);
                // besoin de transformer entity Customers en string (json)
                return $serializer->serialize($customers, 'json', $context);

            });
        return new JsonResponse($customerList, Response::HTTP_OK, [], true);
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
    public function createOneCustomer(Request $request, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        {

            $user = $this->getUser(); // je recupere le user connecté
            $this->cache->invalidateTags(["customerCache"]); // j'invalide le cache
            $customer = $this->serializer->deserialize(
                $request->getContent(), Customer::class, 'json'
            ); // je serialize les data que je recois de la requete
//        dd($customer);
            $this->verifyCustomer($customer); // je vérifie le customer
//            dd($user); // je fais un var_dump
            $customer->setUser($user); // j'ajoute un User au Customer
            $this->em->persist($customer); // j'ecris le sql
            $this->em->flush(); // j'execute le sql => la j'écris dans la base de données

            return new JsonResponse($customer, Response::HTTP_CREATED);
        }

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
    //Cette méthode permet de supprimer un client par rapport à son id.

    /**
     * @throws InvalidArgumentException
     */
    #[Route('/api/customers/{id}', name: 'deleteCustomer', methods: ['DELETE'])]
    public function DeleteCustomer(Customer $customer, EntityManagerInterface $em, TagAwareCacheInterface $cache): JsonResponse
    {
        $em->remove($customer);
        $em->flush();
        // On vide le cache.
        $cache->invalidateTags(["customersCache"]);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
//Cette méthode permet de mettre à jour un client en fonction de son id.

    /**
     * @throws InvalidArgumentException
     */
    #[Route('/api/customers/{id}', name: "updateCustomer", methods: ['PUT'])]

    public function updateCustomer(Request                $request, SerializerInterface $serializer,
                                   Customer               $currentCustomer, EntityManagerInterface $em,
                                   ValidatorInterface $validator,
                                   TagAwareCacheInterface $cache): JsonResponse
    {
        // On vide le cache.
        $cache->invalidateTags(["customersCache"]);

        $newCustomer = $serializer->deserialize($request->getContent(), Customer::class, 'json');

        $currentCustomer->setName($newCustomer->getName());
        $currentCustomer->setEmail($newCustomer->getEmail());
        // On vérifie les erreurs
        $errors = $validator->validate($currentCustomer);
        if ($errors->count() > 0) {
            return new JsonResponse($serializer->serialize($errors, 'json'), Response::HTTP_BAD_REQUEST, [], true);
        }
        $em->persist($currentCustomer);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

}