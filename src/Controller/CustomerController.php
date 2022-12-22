<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use App\Repository\UserRepository;
use App\Security\Voter\CustomerVoter;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Psr\Cache\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

#[Route('/api/customers', name: 'customer_')]
class CustomerController extends AbstractController
{

//Cette méthode permet de récupérer l'ensemble des clients.
    #[Route('', name: 'customers', methods: ['GET'])]
    public function getAllCustomers(CustomerRepository     $customerRepository,
                                    SerializerInterface $serializer,
                                    Request                $request,
                                    TagAwareCacheInterface $cache
    ): JsonResponse
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);


        $idCache = "getAllCustomers-" . $page . "-" . $limit ;
        $customerList = $cache->get($idCache, function (ItemInterface $item) use ($customerRepository, $page, $limit,$value, $serializer) {
      /*      echo("customer");*/
            $item->tag("customersCache");
            $customers = $customerRepository->findAllWithPagination($page, $limit, $this->getUser());
            $context = SerializationContext::create()->setGroups(['getCustomers']);
            return $serializer->serialize($customers, 'json', $context);
        });
        return new JsonResponse($customerList, Response::HTTP_OK, [], true);
    }

//Cette méthode permet de récupérer un customer en particulier en fonction de son id.

    #[Route('/{id}', name: 'detailCustomer', methods: ['GET'])]
    public function getCustomerDetail(Customer $customer, SerializerInterface $serializer): JsonResponse
    {
        $this->denyAccessUnlessGranted(CustomerVoter::VIEW, $customer);
        $context = SerializationContext::create()->setGroups(['getCustomers']);
        $jsonCustomer = $serializer->serialize($customer, 'json', $context);
        return new JsonResponse($jsonCustomer, Response::HTTP_OK, [], true);
    }

//Cette méthode permet de supprimer un client par rapport à son id.

    /**
     * @throws InvalidArgumentException
     */
    #[Route('/{id}', name: 'deleteCustomer', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour supprimer un customer')]
    public function DeleteCustomer(Customer $customer, EntityManagerInterface $em, TagAwareCacheInterface $cache): JsonResponse
    {
        $this->denyAccessUnlessGranted(CustomerVoter::VIEW, $customer);
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
    #[Route('/{id}', name: "updateCustomer", methods: ['PUT'])]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour éditer un client')]
    public function updateCustomer(Request                $request, SerializerInterface $serializer,
                                   Customer $customer,
                                   Customer               $currentCustomer, EntityManagerInterface $em,
                                   UserRepository         $userRepository, ValidatorInterface $validator,
                                   TagAwareCacheInterface $cache): JsonResponse
    {
        $this->denyAccessUnlessGranted(CustomerVoter::VIEW, $customer);
        $newCustomer = $serializer->deserialize($request->getContent(), Customer::class, 'json');
        $currentCustomer->setName($newCustomer->getName());
        $currentCustomer->setEmail($newCustomer->getEmail());
        // On vérifie les erreurs
        $errors = $validator->validate($currentCustomer);
        if ($errors->count() > 0) {
            return new JsonResponse($serializer->serialize($errors, 'json'), Response::HTTP_BAD_REQUEST, [], true);
        }
        $content = $request->toArray();
        $idUser = $content['idUser'] ?? -1;
        $currentCustomer->setUser($userRepository->find($idUser));
        $em->persist($currentCustomer);
        $em->flush();
        // On vide le cache.
        $cache->invalidateTags(["customersCache"]);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
    //Cette méthode permet d'insérer un nouveau client.
    /**
     * @throws InvalidArgumentException
     */
    #[Route('/', name: 'createCustomer', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour créer un client')]
    public function createCustomer(Request                $request, SerializerInterface $serializer,
                                   UrlGeneratorInterface  $urlGenerator, TagAwareCacheInterface $cache,
                                   UserRepository         $userRepository, ValidatorInterface $validator,
                                   EntityManagerInterface $em): JsonResponse
    {
        $customer = $serializer->deserialize($request->getContent(), Customer::class, 'json');
// On vérifie les erreurs
        $errors = $validator->validate($customer);
        if ($errors->count() > 0) {
            return new JsonResponse($serializer->serialize($errors, 'json'), Response::HTTP_BAD_REQUEST, [], true);
            //throw new HttpException(JsonResponse::HTTP_BAD_REQUEST, "La requête est invalide");
        }
        $content = $request->toArray();
        $idUser = $content['idUser'] ?? -1;
        $customer->setUSer($userRepository->find($idUser));
        $em->persist($customer);
        $em->flush();
        // On vide le cache.
        $cache->invalidateTags(["customersCache"]);
        $context = SerializationContext::create()->setGroups(["getCustomers"]);
        $jsonCustomer = $serializer->serialize($customer, 'json', $context);
        $location = $urlGenerator->generate('customer_detailCustomer', ['id' => $customer->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL);
        return new JsonResponse($jsonCustomer, Response::HTTP_CREATED, ["Location" => $location], true);
    }
}