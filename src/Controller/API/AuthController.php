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
        $token = $this->am->fetchAccessToken();

        $data = [
            'access_token' => $token->getAccessToken(),
            'expires' => $token->getExpires(),
            'token_type' => $token->getTokenType(),

            // 後方互換性のため（非推奨）
            'expires_in' => 3600,
        ];

        return $response->withJson([
            'meta' => ['name' => 'Authorization Token'],
            'data' => $data,
        ]);
    }
}
