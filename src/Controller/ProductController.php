<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/products', name: 'product_')]
class ProductController extends AbstractController
{
    #[Route('', name: 'products' , methods: ['GET'])]
    public function getAllProducts(ProductRepository $productRepository, Request $request): JsonResponse
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);

        return $this->json($productRepository->findAllWithPagination($page, $limit), 200, [], ["groups" => ["getProducts"]]);
    }
    #[Route('/{id}', name: 'detailProduct' , methods: ['GET'])]
    public function getProductDetail(Product $product, SerializerInterface $serializer): JsonResponse
    {
        $jsonProduct = $serializer->serialize($product, 'json',['groups' => 'getProducts']);
        return new JsonResponse($jsonProduct, Response::HTTP_OK, [], true);
    }

}
