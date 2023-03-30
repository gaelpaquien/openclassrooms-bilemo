<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class APIService {

    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function getRoutes(mixed $object, array $groups): JsonResponse
    {
        if (!is_array($object) && !is_object($object)) {
            throw new \InvalidArgumentException('The object must be an array or an object');
        }

        foreach ($groups as $group) {
            if (!is_string($group)) {
                throw new \InvalidArgumentException('The group must be a string');
            }
        }

        $options = [
            'groups' => $groups,
            'skip_null_values' => true,
        ];
        try {
            $jsonResponse = $this->serializer->serialize($object, 'json', $options);
        } catch (\Exception $e) {
            throw new BadRequestException('Unable to serialize object');
        }

        return new JsonResponse($jsonResponse, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ], true);
    }
}
