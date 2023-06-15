<?php

declare(strict_types=1);

namespace App\Authorization\Provider;

use App\Authorization\Token\ClientCredentialsToken;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\GenericProvider;

class SmartTheaterProvider
{
    private AbstractProvider $baseProvider;

    public function __construct(
        string $host,
        string $clientId,
        string $clientSecret
    ) {
        $this->baseProvider = new GenericProvider([
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'urlAuthorize' => $host . '/unused',
            'urlAccessToken' => $host . '/oauth2/token',
            'urlResourceOwnerDetails' => $host . '/unused',
        ]);
    }

    public function fetchAccessToken(): ClientCredentialsToken
    {
        return ClientCredentialsToken::create(
            $this->baseProvider->getAccessToken('client_credentials')
        );
    }
}
