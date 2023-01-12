<?php

namespace App\Services;

use App\Entity\Product;
use App\Repository\ProductRepository;

class ProductService
{
    public function __construct(
        private readonly ProductRepository $productRepository
    )
    {

    }
    public function findAll(): array
    {
        return $this->productRepository->findAll();
    }
    public function find(int $id): ?Product
    {
        return $this->productRepository->find($id);
    }
}