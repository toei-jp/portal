<?php

declare(strict_types=1);

namespace App\Authorization\Token;

use League\OAuth2\Client\Token\AccessTokenInterface;

class ClientCredentialsToken
{
    protected string $accessToken;
    protected string $tokenType;
    protected int $expires;

    public static function create(AccessTokenInterface $accessToken): self
    {
        $token = new self();

        $token->accessToken = $accessToken->getToken();
        $token->tokenType   = $accessToken->getValues()['token_type'];
        $token->expires     = $accessToken->getExpires();

        return $token;
    }

    protected function __construct()
    {
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getTokenType(): string
    {
        return $this->tokenType;
    }

    public function getExpires(): int
    {
        return $this->expires;
    }

    public function isExpired(int $time): bool
    {
        return $this->expires < $time;
    }
}
