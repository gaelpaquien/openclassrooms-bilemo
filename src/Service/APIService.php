<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class APIService {

    private SerializerInterface $serializer;

    private EntityManagerInterface $em;

    public function __construct(SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $this->serializer = $serializer;
        $this->em = $em;
    }

    public function post(): JsonResponse
    {
        return new JsonResponse(null, Response::HTTP_CREATED);
    }

    public function get(mixed $object, array $groups): JsonResponse
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

    public function delete(object $object): JsonResponse
    {
        if (!is_object($object)) {
            throw new \InvalidArgumentException('The object must be an object');
        }

        $this->em->remove($object);
        $this->em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
