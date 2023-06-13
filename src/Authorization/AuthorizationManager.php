<?php

declare(strict_types=1);

namespace App\Authorization;

use App\Authorization\Provider\SmartTheaterProvider;
use App\Authorization\Token\ClientCredentialsToken;
use App\Session\Container as SessionContainer;

class AuthorizationManager
{
    private SmartTheaterProvider $provider;
    private SessionContainer $session;

    public function __construct(
        string $server,
        string $clientId,
        string $clientSecret,
        SessionContainer $session
    ) {
        $this->provider = new SmartTheaterProvider(
            'https://' . $server,
            $clientId,
            $clientSecret
        );
        $this->session  = $session;
    }

    public function fetchAccessToken(int $tiem): ClientCredentialsToken
    {
        if (
            isset($this->session['token'])
            && ! $this->session['token']->isExpired($tiem)
        ) {
            return $this->session['token'];
        }

        $accessToken = $this->provider->fetchAccessToken();

        $this->session['token'] = $accessToken;

        return $accessToken;
    }
}
