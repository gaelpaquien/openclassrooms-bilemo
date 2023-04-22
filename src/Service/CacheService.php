<?php

namespace App\Service;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class CacheService
{
    public function __construct(private readonly TagAwareCacheInterface $cache, private readonly SerializerInterface $serializer)
    {
    }

    public function getCache(string $idCache, mixed $resource, string $tag, array $groups): mixed
    {
        return $this->cache->get($idCache, function (ItemInterface $item) use ($resource, $tag, $groups) {
            $item->tag($tag);
            return $this->serializer->serialize($resource, 'json', $groups);
        });
    }

    public function deleteCache(array $tags): void
    {
        $this->cache->invalidateTags($tags);
    }
}