<?php

namespace App\Services;

use App\Repository\CustomerRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;


class CustomerService
{

    // je crée une méthode dans mon Service

    // je crée un constructeur dans des paramètres pour construire ce que je veux
    //avec comme paramètre le customerRepo ù il y a déjà des méthodes faites pas symfony
    public function __construct(
        private readonly CustomerRepository     $customerRepository,
        private readonly TagAwareCacheInterface $cache,
    )
    {

    }

    // je crée une méthode findAll (trouver tous les customer).

    public function cache(Request $request)
    {
        //chercher sur la route une page avec un numéro
        $page = (int)$request->get(key: 'page', default: 1);
        //chercher sur la route avec une limit avec un numéro
        $limit = (int)$request->get(key: 'limit', default: 3);
        //j’ai créé ici un identifiant
        //Il est construit ici avec le mot getAllCustomers
        $idCache = "getAllCustomers-" . $page . "-" . $limit;

        return $this->cache->get($idCache, function (ItemInterface $item) use ($page, $limit) {
            $item->tag("customersCache");
            return $this->findAllWithPagination($page, $limit);
        });

    }

    public function findAllWithPagination($page, $limit)
    {
        // Une méthode qui est dans le customerRepo et qui envoie un tableau d'objets
        // Avec 2 paramètres page et limit
        return $this->customerRepository->findAllWithPagination($page, $limit);

    }

    public function find(int $id)
    {
        return $this->customerRepository->find($id);
    }

}