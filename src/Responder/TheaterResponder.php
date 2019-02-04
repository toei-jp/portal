<?php
/**
 * TheaterResponder.php
 * 
 * @author Atsushi Okui <okui@motionpicture.jp>
 */

namespace Toei\Portal\Responder;

use Slim\Collection;

use Psr\Http\Message\ResponseInterface as Response;

/**
 * Theater responder
 */
class TheaterResponder extends BaseResponder
{
    /**
     * index
     *
     * @param Response   $response
     * @param Collection $data
     * @return Response
     */
    public function index(Response $response, Collection $data)
    {
        return $this->view->render($response, 'theater/index.html.twig', $data->all());
    }
    
    /**
     * topic list
     *
     * @param Response   $response
     * @param Collection $data
     * @return Response
     */
    public function topicList(Response $response, Collection $data)
    {
        return $this->view->render($response, 'theater/topic/list.html.twig', $data->all());
    }
    
    /**
     * topic detail
     *
     * @param Response   $response
     * @param Collection $data
     * @return Response
     */
    public function topicDetail(Response $response, Collection $data)
    {
        return $this->view->render($response, 'theater/topic/detail.html.twig', $data->all());
    }
}