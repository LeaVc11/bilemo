<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\CustomerRepository;
use App\Repository\UserRepository;
use App\Services\UserService;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class UserController extends AbstractController
{
    public function __construct(

    )
    {
    }
    #[Route('/api/users', name: 'users', methods: ['GET'])]
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
    public function getOnelUser(User $user, SerializerInterface $serializer): JsonResponse
    {
        $context = SerializationContext::create()->setGroups(['getUsers']);

        $jsonUser = $serializer->serialize($user, 'json', $context);
        return new JsonResponse($jsonUser, Response::HTTP_OK, [], true);
    }
//    /**
//     * @throws InvalidArgumentException
//     */
//    #[Route('/api/users', name: 'createUser', methods: ['POST'])]
//    public function createOneUser(Request $request,
//                               UrlGeneratorInterface  $urlGenerator,
//                               TagAwareCacheInterface $cache,
//                               SerializerInterface $serializer,
//                               EntityManagerInterface $em,
//                               CustomerRepository $customerRepository,
//                               ValidatorInterface $validator): JsonResponse
//    {
//        $user = $serializer->deserialize($request->getContent(), User::class, 'json');
//
//        // On vérifie les erreurs
//        $errors = $validator->validate($user);
//        if ($errors->count() > 0) {
//            return new JsonResponse($serializer->serialize($errors, 'json'), Response::HTTP_BAD_REQUEST, [], true);
//            //throw new HttpException(JsonResponse::HTTP_BAD_REQUEST, "La requête est invalide");
//        }
//        $content = $request->toArray();
//        $idCustomer = $content['idCustomer'] ?? -1;
//        $user->setCustomer($customerRepository->find($idCustomer));
//
//        $em->persist($user);
//        $em->flush();
//        $cache->invalidateTags(["usersCache"]);
//        $context = SerializationContext::create()->setGroups(["getUsers"]);
//        $jsonUser = $serializer->serialize($user, 'json', $context);
//        $location = $urlGenerator->generate('user_detailUser', ['id' => $user->getId()],
//            UrlGeneratorInterface::ABSOLUTE_URL);
//        return new JsonResponse($jsonUser, Response::HTTP_CREATED, [], true);
//    }




}
