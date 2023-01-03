<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Nelmio\ApiDocBundle\Annotation\Model;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Attributes as OA;


class ProductController extends AbstractController
{
    /**
     * @throws InvalidArgumentException
     */
    #[Route('/api/products', name: 'products' , methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description:"Retourne la liste des products",
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Product::class, groups: ['getProducts']))
        )
    )]
    #[OA\Parameter(
        name: "page",
        description: "La page que l'on veut récupérer",
        in: "query",
    )]
    #[OA\Parameter(
        name: "limit",
        description: "Le nombre d'éléments que l'on veut récupérer",
        in: "query",
    )]
    #[OA\Tag('Products')]
    public function getAllProducts(ProductRepository $productRepository, Request $request): JsonResponse
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);

        return $this->json($productRepository->findAllWithPagination($page, $limit), 200, [], ["groups" => ["getProducts"]]);

    }
    #[Route('/api/products/{id}', name: 'detail_product' , methods: ['GET'])]
    #[OA\Tag('Products')]
    public function getOneProduct(Product $product, SerializerInterface $serializer): JsonResponse
    {
        $jsonProduct = $serializer->serialize($product, 'json',['groups' => "getProducts"]);
        return new JsonResponse($jsonProduct, Response::HTTP_OK, [], true);
    }


}
