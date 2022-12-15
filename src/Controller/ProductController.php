<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

#[Route('/api/products', name: 'product_')]
class ProductController extends AbstractController
{
    #[Route('', name: 'products' , methods: ['GET'])]
    public function getAllProducts(ProductRepository $productRepository, SerializerInterface $serializer, Request $request, TagAwareCacheInterface $cache): JsonResponse
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 5);

        $idCache = "getAllProducts-" . $page . "-" . $limit;

        $productList = $cache->get($idCache, function (ItemInterface $item) use ($productRepository, $page, $limit, $serializer){
            echo ("L'ELEMENT N'EST PAS ENCORE EN CACHE !\n");
            $item->tag("productCache");
        return $productRepository->findAllWithPagination($page, $limit);
    });
        return $this->json($productList, 200, [], ["groups" => ["getProducts"]]);

    }
    #[Route('/{id}', name: 'detailProduct' , methods: ['GET'])]
    public function getProductDetail(Product $product, SerializerInterface $serializer): JsonResponse
    {
        $jsonProduct = $serializer->serialize($product, 'json',['groups' => 'getProducts']);
        return new JsonResponse($jsonProduct, Response::HTTP_OK, [], true);
    }
    #[Route('/{id}', name: 'deleteProduct' , methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour supprimer un user')]

    public function DeleteProduct(Product $product, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($product);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
