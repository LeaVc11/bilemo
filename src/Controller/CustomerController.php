<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
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
use OpenApi\Attributes as OA;


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

    /**
     * @throws InvalidArgumentException
     */
    #[Route('/api/customers', name: 'customers', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description:"Retourne la liste des customers",
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
//    /**
//     * @OA\Response(
//     *     response=200,
//     *     description="Retourne la liste des customers",
//     *     @OA\JsonContent(
//     *        type="array",
//     *        @OA\Items(ref=@Model(type=Customer::class, groups={"getCustomers"}))
//     *     )
//     * )
//     * @OA\Parameter(
//     *     name="page",
//     *     in="query",
//     *     description="La page que l'on veut récupérer",
//     *     @OA\Schema(type="int")
//     * )
//     * @OA\Parameter(
//     *     name="limit",
//     *     in="query",
//     *     description="Le nombre d'éléments que l'on veut récupérer",
//     *     @OA\Schema(type="int")
//     * )
//     * @OA\Tag(name="Customers")
//     *
//     */
    #[OA\Tag('Customers')]
    public function getAllCustomers(SerializerInterface $serializer, CustomerRepository $customerRepository, TagAwareCacheInterface $cache, Request $request): JsonResponse
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);
        $idCache = "getAllCustomers-" . $page . "-" . $limit;
        $customerList = $cache->get($idCache,
            function (ItemInterface $item) use ($customerRepository, $page, $limit, $serializer) {
                echo("customer");
                $item->tag("customersCache");
                $customers = $customerRepository->findAllWithPagination($page, $limit, $this->getUser());
                $context = SerializationContext::create()->setGroups(['getCustomers']);
                return $serializer->serialize($customers, 'json', $context);

            });
//        return new JsonResponse($customerList, Response::HTTP_OK, [], true);
        return $this->json($customerList,Response::HTTP_OK );
    }
    #[Route('/api/customers/{id}', name: 'detail_customer', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour voir un customer')]
    #[OA\Tag('Customers')]
    public function getOneCustomer(Customer $customer,Request $request, SerializerInterface $serializer)
    {
        $this->denyAccessUnlessGranted('CUSTOMER_VIEW', $customer);
        $id = $request->get('id');
        $customerData = $this->customerRepository->find($id);
        $context = SerializationContext::create()->setGroups(['getCustomers']);
        $json = $serializer->serialize($customerData, 'json', $context);
//        return new JsonResponse($json, Response::HTTP_OK, [], true);
        return $this->json($json,Response::HTTP_OK );
    }
    /**
     * @throws InvalidArgumentException
     */
    #[Route('/api/customers', name: 'createCustomer', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour créer un customer')]
    #[OA\Tag('Customers')]
    public function createOneCustomer(Request $request): JsonResponse
    {
        {
            $user = $this->getUser();
            $this->cache->invalidateTags(["customerCache"]);
            $customer = $this->serializer->deserialize(
                $request->getContent(), Customer::class, 'json'
            );
            $this->verifyCustomer($customer);
            $customer->setUser($user);
            $this->em->persist($customer);
            $this->em->flush();
//            return new JsonResponse($customer, Response::HTTP_CREATED);
            return $this->json($customer,Response::HTTP_CREATED);

        }

    }
    private function verifyCustomer($customer): bool
    {
        if (!$this->customerRepository->findOneBy(['email' => $customer->getEmail()])) {
            return true;
        }
        return false;
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
//        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        return $this->json(null,Response::HTTP_NO_CONTENT);
    }
    /**
     * @throws InvalidArgumentException
     */
    #[Route('/api/customers/{id}', name: "updateCustomer", methods: ['PUT'])]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour mettre à jour un customer')]
    #[OA\Tag('Customers')]
    public function updateCustomer(Request                $request, SerializerInterface $serializer,
                                   Customer               $currentCustomer, EntityManagerInterface $em,
                                   ValidatorInterface $validator, Customer $customer,
                                   TagAwareCacheInterface $cache): JsonResponse
    {
        $this->denyAccessUnlessGranted('CUSTOMER_UPDATE', $customer);
        $cache->invalidateTags(["customersCache"]);
        $newCustomer = $serializer->deserialize($request->getContent(), Customer::class, 'json');
        $currentCustomer->setName($newCustomer->getName());
        $currentCustomer->setEmail($newCustomer->getEmail());
        $errors = $validator->validate($currentCustomer);
        if ($errors->count() > 0) {
//            return new JsonResponse($serializer->serialize($errors, 'json'), Response::HTTP_BAD_REQUEST, [], true);
            return $this->json(null,Response::HTTP_BAD_REQUEST);
        }
        $em->persist($currentCustomer);
        $em->flush();
//        return new JsonResponse(null, Response::HTTP_OK);
        return $this->json(null,Response::HTTP_OK);
    }
}