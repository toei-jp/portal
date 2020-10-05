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

    /**
     * advance ticket
     *
     * @param Response   $response
     * @param Collection $data
     * @return Response
     */
    public function advanceTicket(Response $response, Collection $data)
    {
        return $this->view->render($response, 'theater/advance_ticket/index.html.twig', $data->all());
    }

    /**
     * price
     *
     * @param Response   $response
     * @param Collection $data
     * @return Response
     */
    public function price(Response $response, Collection $data)
    {
        return $this->view->render($response, 'theater/price/index.html.twig', $data->all());
    }

    /**
     * floor guide
     *
     * @param Response   $response
     * @param Collection $data
     * @return Response
     */
    public function floorGuide(Response $response, Collection $data)
    {
        return $this->view->render($response, 'theater/floor_guide/index.html.twig', $data->all());
    }

    /**
     * access
     *
     * @param Response   $response
     * @param Collection $data
     * @return Response
     */
    public function access(Response $response, Collection $data)
    {
        return $this->view->render($response, 'theater/access/index.html.twig', $data->all());
    }
}
