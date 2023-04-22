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
    public function __construct(private readonly SerializerInterface $serializer, private readonly EntityManagerInterface $em, private readonly UrlGeneratorInterface $urlGenerator, private readonly CacheService $cacheService)
    {
    }

    private function getOptions(array $groups): array
    {
        foreach ($groups as $group) {
            if (!\is_string($group)) {
                throw new \InvalidArgumentException('The group must be a string');
            }
        }

        return [
            'groups' => $groups,
            'skip_null_values' => true,
        ];
    }

    private function serialize(mixed $resource, array $groups, ?string $idCache, ?string $tag): string
    {
        if ($idCache !== null && $tag !== null) {
            try {
                $jsonResponse = $this->cacheService->getCache($idCache, $resource, $tag, $this->getoptions($groups));
            } catch (\Exception) {
                throw new BadRequestException('Unable to serialize resource with cache');
            }
        } else {
            try {
                $jsonResponse = $this->serializer->serialize($resource, 'json', $this->getoptions($groups));
            } catch (\Exception) {
                throw new BadRequestException('Unable to serialize resource');
            }
        }

        return $jsonResponse;
    }

    public function post(mixed $resource, string $location, array $groups): JsonResponse
    {
        $jsonResponse = $this->serialize($resource, $groups, null, null);

        return new JsonResponse(
            $jsonResponse,
            Response::HTTP_CREATED, [
                'Location' => $location
            ],
            true
        );
    }

    public function get(mixed $resource, array $groups, ?string $idCache = null, ?string $tag = null): JsonResponse
    {
        if (!\is_array($resource) && !\is_object($resource)) {
            throw new \InvalidArgumentException('The resource must be an array or an object');
        }

        $jsonResponse = $this->serialize($resource, $groups, $idCache, $tag);

        return new JsonResponse(
            $jsonResponse,
            Response::HTTP_OK, [
                'Content-Type' => 'application/json',
            ],
            true
        );
    }

    public function delete(object $resource, ?array $tags = null): JsonResponse
    {
        if (!\is_object($resource)) {
            throw new \InvalidArgumentException('The resource must be an object');
        }

        if ($tags !== null) {
            $this->cacheService->deleteCache($tags);
        }

        $this->em->remove($resource);
        $this->em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
