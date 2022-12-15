<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Cache\InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

#[Route('/api/customers', name: 'customer_')]
class CustomerController extends AbstractController
{
    /**
     * @throws InvalidArgumentException
     */
    #[Route('', name: 'customers', methods: ['GET'])]
    public function getAllCustomers(
        CustomerRepository $customerRepository,
        Request $request,
        TagAwareCacheInterface $cache
    ): JsonResponse
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);

        $idCache = "getAllCustomers-" . $page . "-" . $limit;
        $customerList = $cache->get($idCache, function(ItemInterface $item) use ($customerRepository, $page, $limit){
            echo ("customer");
            $item->tag("customersCache");
            return $customerRepository->findAllWithPagination($page, $limit);
        });

        return $this->json($customerList, 200, [], ["groups" => ["getCustomers", "getUsers"]]);
    }
    #[Route('/', name: 'createCustomer', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour créer un client')]

    public function createCustomer(Request $request, SerializerInterface $serializer,
                                   EntityManagerInterface $em): JsonResponse
    {
        $customer = $serializer->deserialize($request->getContent(), Customer::class, 'json');

        $em->persist($customer);
        $em->flush();
        $jsonCustomer = $serializer->serialize($customer, 'json', ['groups' => 'getCustomers']);
        return new JsonResponse($jsonCustomer, Response::HTTP_CREATED, [], true);
    }
    #[Route('/{id}', name: 'detailCustomer' , methods: ['GET'])]
    public function getCustomerDetail(Customer $customer, SerializerInterface $serializer): JsonResponse
    {
        $jsonCustomer = $serializer->serialize($customer, 'json');
        return new JsonResponse($jsonCustomer, Response::HTTP_OK, [], true);
    }
    #[Route('/{id}', name: 'deleteCustomer' , methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour supprimer un client')]
    public function DeleteProduct(Customer $customer, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($customer);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

}