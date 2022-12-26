<?php

namespace App\Services;

use App\Entity\Product;
use App\Repository\ProductRepository;

class ProductService
{
    // je crée une méthode dans mon Service

    // je crée un constructeur dans des paramètres pour construire ce que je veux
    //avec comme paramètre le productRepo ù il y a déjà des méthodes faites pas symfony
    public function __construct(
        private readonly ProductRepository $productRepository
    )
    {

    }
    // je crée une méthode findAll (trouver tous les produits) un id dans l'entity Product
    public function findAll(): array
    {
        //retourne à cette méthode. Une méthode qui est dans le ProductRepo et qui envoie un message
        return $this->productRepository->findAll();
//        dd($this->userRepository->findAll());
    }
    // je crée une méthode find (trouver) un id dans l'entity Product
    public function find(int $id): ?Product
    {
        //retourne à cette méthode. Une méthode qui est dans leProductRepo
        return $this->productRepository->find($id);
    }

}