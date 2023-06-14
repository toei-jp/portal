<?php

declare(strict_types=1);

namespace App\Authorization;

use App\Authorization\Provider\SmartTheaterProvider;
use App\Authorization\Token\ClientCredentialsToken;
use DateTimeImmutable;

class AuthorizationManager
{
    private SmartTheaterProvider $provider;
    private Cache $cache;

    public function __construct(
        string $server,
        string $clientId,
        string $clientSecret,
        Cache $cache
    ) {
        $this->provider = new SmartTheaterProvider(
            'https://' . $server,
            $clientId,
            $clientSecret
        );
        $this->cache    = $cache;
    }

    public function fetchAccessToken(): ClientCredentialsToken
    {
        $cachedToken = $this->cache->getToken();

        if (! is_null($cachedToken)) {
            return $cachedToken;
        }

        $token = $this->provider->fetchAccessToken();

        $expiration = (new DateTimeImmutable())->setTimestamp($token->getExpires());
        $this->cache->saveToken($token, $expiration);

        return $token;
    }
}
