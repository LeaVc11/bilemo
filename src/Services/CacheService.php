<?php

namespace App\Services;

use App\Repository\CustomerRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class CacheService
{
    private TagAwareCacheInterface $cache;

    public function __construct(TagAwareCacheInterface $cache)
    {
        $this->cache = $cache;
    }
    /**
     * @throws InvalidArgumentException
     */
    public function cache(Request $request, CustomerRepository  $customerRepository)
    {
        $page = (int) $request->get(key:'page', default: 1);
        $limit = (int) $request->get(key: 'limit', default: 10);

        $idCache = "getAllCustomers-".$page."-".$limit;

        return $this->cache->get($idCache, function (ItemInterface $item)
        use (
            $customerRepository,
            $page, $limit,
        ) {
            /*      echo("customer");*/
            $item->tag("customersCache");
            return $this->findAllWithPagination($page, $limit);
            });

    }
}
