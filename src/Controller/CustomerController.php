<?php

namespace App\Controller;

use App\Services\CustomerService;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CustomerController extends AbstractController
{
    public function __construct(
        private readonly CustomerService $customerService
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
        //chercher la méthode find qui est ds le customerService
        $customerData = $this->customerService->find($id);
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
    public function createCustomer(Request $request): JsonResponse
    {
        $customer = $this->customerService->create($request);
        return new JsonResponse($customer, Response::HTTP_CREATED);
    }


}