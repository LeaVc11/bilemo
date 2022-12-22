<?php

namespace App\Services;

use App\Entity\Customer;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SerializeService
{

    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function SendSerialize(mixed $dataToSerialize,
                                  array    $groupContext): JsonResponse
    {
        $context = SerializationContext::create()->setGroups($groupContext);
        $jsonCustomer = $this->serializer->serialize($$dataToSerialize, 'json', $context);
        return new JsonResponse($jsonCustomer, Response::HTTP_OK, [], true);
    }
}