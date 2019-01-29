<?php
/**
 * AuthController.php
 * 
 * @author Atsushi Okui <okui@motionpicture.jp>
 */

namespace Toei\Portal\Controller\API;

use GuzzleHttp\Client as HttpClient;
use Twig\Extension\StringLoaderExtension;

/**
 * Auth controller
 */
class AuthController extends BaseController
{
    /**
     * token action
     * 
     * @link https://m-p.backlog.jp/view/TOEI-112
     * 
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     * @param array               $args
     * @return string|void
     */
    public function executeToken($request, $response, $args)
    {
        $meta = [
            'name' => 'Authorization Token',
        ];
        $this->data->set('meta', $meta);
        
        $response = $this->requestToken();
        
        $rawData = $response->getBody()->getContents();
        $data = json_decode($rawData, true);
        
        $this->data->set('data', $data);
    }
    
    /**
     * request Token
     * 
     * @link https://docs.aws.amazon.com/ja_jp/cognito/latest/developerguide/token-endpoint.html
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function requestToken(): \Psr\Http\Message\ResponseInterface
    {
        $endpoint = '/oauth2/token';
        $headers = [
            'Authorization' => $this->createAuthStr(),
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];
        $params = [
            'grant_type' => 'client_credentials',
        ];
        
        $httpClient = $this->createHttpClient();
        $response = $httpClient->post($endpoint, [
            'headers' => $headers,
            'form_params' => $params,
        ]);
        
        return $response;
    }
    
    /**
     * create HTTP Client
     *
     * @return HttpClient
     */
    protected function createHttpClient(): HttpClient
    {
        $config = [
            'timeout' => 5, // ひとまず5秒
            'connect_timeout' => 5, // ひとまず5秒
            'http_errors' => true,
        ];
        
        $config['base_uri'] = 'https://' . 'toei-cinerino-development.auth.ap-northeast-1.amazoncognito.com';
        
        return new HttpClient($config);
    }
    
    /**
     * create Authorization string
     *
     * @return String
     */
    protected function createAuthStr(): String
    {
        $clientId = '6r1gts0rac17him965il1p8jrt';
        $clientSecret = '190b0pc64or9midfleursrbcoe2qa52uvla6ag4sulvvlie88l13';
        
        return 'Basic ' . base64_encode($clientId . ':' . $clientSecret);
    }
}