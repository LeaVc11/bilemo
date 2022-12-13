<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/products', name: 'product_')]
class ProductController extends AbstractController
{
    #[Route('', name: 'products' , methods: ['GET'])]
    public function getAllProducts(ProductRepository $productRepository): JsonResponse
    {
//        $productList = $productRepository->findAll();
//
//        $jsonProductList = $serializer->serialize($productList, 'json', ['groups' => 'getProducts']);
//        return new JsonResponse($jsonProductList, Response::HTTP_OK, [], true);
        return $this->json($productRepository->findAll());

    }
    #[Route('/{id}', name: 'detailProduct' , methods: ['GET'])]
    public function getProductDetail(Product $product, SerializerInterface $serializer): JsonResponse
    {
        $jsonProduct = $serializer->serialize($product, 'json',['groups' => 'getProducts']);
        return new JsonResponse($jsonProduct, Response::HTTP_OK, [], true);
    }
    #[Route('/{id}', name: 'deleteProduct' , methods: ['DELETE'])]
    public function DeleteProduct(Product $product, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($product);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

}
