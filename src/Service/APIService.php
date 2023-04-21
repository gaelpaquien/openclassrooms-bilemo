<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class APIService
{
    public function __construct(private readonly SerializerInterface $serializer, private readonly EntityManagerInterface $em, private readonly UrlGeneratorInterface $urlGenerator)
    {
    }

    public function post(mixed $resource, string $location, array $groups): JsonResponse
    {
        foreach ($groups as $group) {
            if (!\is_string($group)) {
                throw new \InvalidArgumentException('The group must be a string');
            }
        }

        $options = [
            'groups' => $groups,
            'skip_null_values' => true,
        ];

        try {
            $jsonResponse = $this->serializer->serialize($resource, 'json', $options);
        } catch (\Exception) {
            throw new BadRequestException('Unable to serialize resource');
        }

        $location = $this->urlGenerator->generate(
            $location, [
                'id' => $resource->getId(),
                'companyId' => $resource->getCompany()->getId(),
            ],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        return new JsonResponse($jsonResponse, Response::HTTP_CREATED, ['Location' => $location], true);
    }

    public function get(mixed $resource, array $groups): JsonResponse
    {
        if (!\is_array($resource) && !\is_object($resource)) {
            throw new \InvalidArgumentException('The resource must be an array or an object');
        }

        foreach ($groups as $group) {
            if (!\is_string($group)) {
                throw new \InvalidArgumentException('The group must be a string');
            }
        }

        $options = [
            'groups' => $groups,
            'skip_null_values' => true,
        ];

        try {
            $jsonResponse = $this->serializer->serialize($resource, 'json', $options);
        } catch (\Exception) {
            throw new BadRequestException('Unable to serialize resource');
        }

        return new JsonResponse(
            $jsonResponse,
            Response::HTTP_OK, [
                'Content-Type' => 'application/json',
            ],
            true
        );
    }

    public function delete(object $resource): JsonResponse
    {
        if (!\is_object($resource)) {
            throw new \InvalidArgumentException('The resource must be an object');
        }

        $this->em->remove($resource);
        $this->em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
