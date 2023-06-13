<?php

declare(strict_types=1);

namespace App\Controller\API;

use Slim\Http\Request;
use Slim\Http\Response;

class AuthController extends BaseController
{
    /**
     * token action
     *
     * @link https://m-p.backlog.jp/view/TOEI-409
     * @link https://m-p.backlog.jp/view/TOEI-112
     *
     * @param array<string, mixed> $args
     */
    public function executeToken(Request $request, Response $response, array $args): Response
    {
        $accessToken = $this->am->fetchAccessToken(time());

        $data = [
            'access_token' => $accessToken->getAccessToken(),
            'expires' => $accessToken->getExpires(),
            'token_type' => $accessToken->getTokenType(),

            // 後方互換性のため（非推奨）
            'expires_in' => 3600,
        ];

        return $response->withJson([
            'meta' => ['name' => 'Authorization Token'],
            'data' => $data,
        ]);
    }
}
