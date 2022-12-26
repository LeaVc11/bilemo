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

    public function SendSerialize(array $groupContext): \JMS\Serializer\Context|SerializationContext
    {
        return SerializationContext::create()->setGroups($groupContext);

    }
}