<?php

declare(strict_types=1);

namespace Tests\Unit\Authorization\Token;

use League\OAuth2\Client\Token\AccessTokenInterface;

class TestAccessToken implements AccessTokenInterface
{
    private string $token;
    private string $tokenType;
    private int $expires;

    public function __construct(string $token, string $tokenType, int $expires)
    {
        $this->token     = $token;
        $this->tokenType = $tokenType;
        $this->expires   = $expires;
    }

    /**
     * @inheritdoc
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @inheritdoc
     */
    public function getRefreshToken()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * @inheritdoc
     */
    public function hasExpired()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function getValues()
    {
        return [
            'token_type' => $this->tokenType,
        ];
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return (string) $this->getToken();
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return [];
    }
}
