<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use OpenApi\Attributes as OA;

class UserController extends AbstractController
{
    public function __construct(

    )
    {
    }
    #[Route('/api/users', name: 'users', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description:"Retourne la liste des users",
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: User::class, groups: ['getUsers']))
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
    #[OA\Tag('Users')]
    public function getAllUsers(UserRepository         $userRepository,
                                Request                $request,
                                SerializerInterface $serializer,
                                TagAwareCacheInterface $cache
    ): JsonResponse
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);

        $idCache = "getAllUsers-" . $page . "-" . $limit;
        $userList = $cache->get($idCache, function (ItemInterface $item) use ($userRepository, $page, $limit, $serializer) {
            echo("user");
            $item->tag("usersCache");
            $users = $userRepository->findAllWithPagination($page, $limit);
            $context = SerializationContext::create()->setGroups(['getUsers']);
            return $serializer->serialize($users, 'json', $context);
        });

        return new JsonResponse($userList, Response::HTTP_OK, [], true);
    }
    #[Route('/api/users/{id}', name: 'detail_user', methods: ['GET'])]
    #[OA\Tag('Users')]
    public function getOnelUser(User $user, SerializerInterface $serializer): JsonResponse
    {
        $context = SerializationContext::create()->setGroups(['getUsers']);

        $jsonUser = $serializer->serialize($user, 'json', $context);
        return new JsonResponse($jsonUser, Response::HTTP_OK, [], true);
    }
}
