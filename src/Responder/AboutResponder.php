<?php
/**
 * AboutResponder.php
 *
 * @author Atsushi Okui <okui@motionpicture.jp>
 */

namespace Toei\Portal\Responder;

use Slim\Collection;

use Psr\Http\Message\ResponseInterface as Response;

/**
 * About responder
 */
class AboutResponder extends BaseResponder
{
    /**
     * faq
     *
     * @param Response   $response
     * @param Collection $data
     * @return Response
     */
    public function faq(Response $response, Collection $data)
    {
        return $this->view->render($response, 'about/faq.html.twig', $data->all());
    }
    
    /**
     * law
     *
     * @param Response   $response
     * @param Collection $data
     * @return Response
     */
    public function law(Response $response, Collection $data)
    {
        return $this->view->render($response, 'about/law.html.twig', $data->all());
    }
}