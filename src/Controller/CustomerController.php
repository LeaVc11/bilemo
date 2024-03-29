<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Psr\Cache\InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
    )
    {
    }

    /**
     * @throws InvalidArgumentException
     */
    #[Route('/api/customers', name: 'customers', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: "Retourne la liste des customers",
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Customer::class, groups: ['getCustomers']))
        )
    )]
    #[OA\Parameter(
        name: "page",
        description: "La page que l'on veut récupérer",
        in: "query",
    )]
    #[OA\Parameter(
        name: "limit",
        description: "Le nombre d'éléments que l'on veut récupérer",
        in: "query",
    )]
    #[OA\Tag('Customers')]
    public function getAllCustomers(SerializerInterface    $serializer,
                                    CustomerRepository     $customerRepository,
                                    TagAwareCacheInterface $cache,
                                    Request                $request): JsonResponse
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);
        $idCache = "getAllCustomers-" . $page . "-" . $limit;
        $customerList = $cache->get($idCache,
            function (ItemInterface $item) use ($customerRepository, $page, $limit, $serializer) {
                echo("customer");
                $item->tag("customersCache");
                $item->expiresAfter(60);
                $customers = $customerRepository->findAllWithPagination($page, $limit, $this->getUser());
                $context = SerializationContext::create()->setGroups(['getCustomers']);
                return $serializer->serialize($customers, 'json', $context);
            });
        return new JsonResponse($customerList, Response::HTTP_OK, [], true);

    }

    #[Route('/api/customers/{id}', name: 'detail_customer', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour voir un customer')]
    #[OA\Tag('Customers')]
    public function getOneCustomer(Request $request, Customer $customer, SerializerInterface $serializer)
    {
        $this->denyAccessUnlessGranted('CUSTOMER_VIEW', $customer);
        $id = $request->get('id');
        $customerData = $this->customerRepository->find($id);
        $context = SerializationContext::create()->setGroups(['getCustomers']);
        $json = $serializer->serialize($customerData, 'json', $context);
        return new JsonResponse($json, Response::HTTP_OK, [], true);

    }

    /**
     * @throws InvalidArgumentException
     */
    #[Route('/api/customers', name: 'createCustomer', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour créer un customer')]
    #[OA\Tag('Customers')]
    public function createOneCustomer(Request                $request,
                                      ValidatorInterface     $validator,
                                      TagAwareCacheInterface $cache,
                                      EntityManagerInterface $em,
                                      SerializerInterface    $serializer): JsonResponse
    {

            $user = $this->getUser();
            $cache->invalidateTags(["customerCache"]);
            $customer = $serializer->deserialize($request->getContent(), Customer::class, 'json');

            $customer->setUser($user);
            $errors = $validator->validate($customer);
            if ($errors->count() > 0) {
                return new JsonResponse($serializer->serialize($errors, 'json'), Response::HTTP_BAD_REQUEST, [], true);
            }
            $em->persist($customer);
            $em->flush();
            $jsonCustomer = $serializer->serialize($customer, 'json');
        return new JsonResponse($jsonCustomer, Response::HTTP_CREATED, [], true);

    }

    /**
     * @throws InvalidArgumentException
     */
    #[Route('/api/customers/{id}', name: 'deleteCustomer', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour supprimer un customer')]
    #[OA\Tag('Customers')]
    public function DeleteCustomer(Customer $customer, EntityManagerInterface $em, TagAwareCacheInterface $cache): JsonResponse
    {
        $this->denyAccessUnlessGranted('CUSTOMER_DELETE', $customer);
        $em->remove($customer);
        $em->flush();
        $cache->invalidateTags(["customersCache"]);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @throws InvalidArgumentException
     */
    #[Route('/api/customers/{id}', name: "updateCustomer", methods: ['PUT'])]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour mettre à jour un customer')]
    #[OA\Tag('Customers')]
    public function updateCustomer(Request                $request, SerializerInterface $serializer,
                                   Customer               $currentCustomer, EntityManagerInterface $em,
                                   ValidatorInterface     $validator, Customer $customer,
                                   TagAwareCacheInterface $cache): JsonResponse
    {
        $this->denyAccessUnlessGranted('CUSTOMER_UPDATE', $customer);
        $cache->invalidateTags(["customersCache"]);

        $newCustomer = $serializer->deserialize($request->getContent(), Customer::class, 'json');

        $currentCustomer->setName($newCustomer->getName());
        $currentCustomer->setEmail($newCustomer->getEmail());
        $errors = $validator->validate($currentCustomer);
        if ($errors->count() > 0) {
            return new JsonResponse($serializer->serialize($errors, 'json'), Response::HTTP_BAD_REQUEST, [], true);
        }
        $em->persist($currentCustomer);
        $em->flush();
        $jsonCustomer = $serializer->serialize($customer, 'json');
        return new JsonResponse($jsonCustomer, Response::HTTP_OK,[], true);
    }
}