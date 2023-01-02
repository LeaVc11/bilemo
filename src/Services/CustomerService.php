<?php

namespace App\Services;

use App\Entity\Customer;
use App\Entity\User;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;


class CustomerService
{

    public function __construct(
        private readonly CustomerRepository     $customerRepository,
        private readonly TagAwareCacheInterface $cache,
        private readonly SerializerInterface    $serializer,
    )
    {
    }
    public function cache(Request $request)
    {
        $page = (int)$request->get(key: 'page', default: 1);
        $limit = (int)$request->get(key: 'limit', default: 3);
        $idCache = "getAllCustomers-" . $page . "-" . $limit;

        return $this->cache->get($idCache, function (ItemInterface $item) use ($page, $limit) {
            echo("customer");
            $item->tag("customersCache");
            return $this->findAllWithPagination($page, $limit);
        });
    }
    public function find(int $id): ?Customer
    {
        return $this->customerRepository->find($id);
    }
    public function findAllWithPagination($page, $limit)
    {
        return $this->customerRepository->findAllWithPagination($page, $limit);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function create(Request $request, User $user)
    {
        $this->cache->invalidateTags(["customerCache"]);
        $customer = $this->serializer->deserialize(
            $request->getContent(), Customer::class, 'json'
        );
        $this->verifyCustomer($customer);
        $customer->setUser($user);
        return $customer;
    }

    private function verifyCustomer($customer): bool
    {
        if (!$this->customerRepository->findOneBy(['email' => $customer->getEmail()])) {
            return true;
        }
        return false;
    }


}