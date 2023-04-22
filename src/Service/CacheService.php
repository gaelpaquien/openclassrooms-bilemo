<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

final class CacheService
{
    public function __construct(private readonly TagAwareCacheInterface $cache, private readonly SerializerInterface $serializer)
    {
    }

    public function getCache(string $idCache, mixed $resource, string $tag, array $groups): mixed
    {
        return $this->cache->get(
            $idCache, function (ItemInterface $item) use ($resource, $tag, $groups): string {
                $item->tag($tag);
                return $this->serializer->serialize($resource, 'json', $groups);
            }
        );
    }

    public function deleteCache(array $tags): void
    {
        $this->cache->invalidateTags($tags);
    }
}
