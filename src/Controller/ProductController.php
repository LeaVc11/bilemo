<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/products', name: 'product_')]
class ProductController extends AbstractController
{
    #[Route('', name: 'app_product')]
    public function getProductList(ProductRepository $productRepository, SerializerInterface $serializer): JsonResponse
    {
        $productList = $productRepository->findAll();
        $jsonBookList = $serializer->serialize($productList, 'json');
        return new JsonResponse($jsonBookList, Response::HTTP_OK, [], true);
    }
}
