<?php

declare(strict_types=1);

namespace App\Authorization;

use App\Authorization\Token\ClientCredentialsToken;
use DateTimeInterface;
use Psr\Cache\CacheItemPoolInterface;

class Cache
{
    private const TOKEN_KEY = 'auth.token';

    private CacheItemPoolInterface $cache;

    public function __construct(CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
    }

    public function getToken(): ?ClientCredentialsToken
    {
        $item = $this->cache->getItem(self::TOKEN_KEY);

        return $item->get();
    }

    public function saveToken(
        ClientCredentialsToken $token,
        ?DateTimeInterface $expiration = null
    ): void {
        $item = $this->cache->getItem(self::TOKEN_KEY);
        $item
            ->set($token)
            ->expiresAt($expiration);

        $this->cache->save($item);
    }
}
