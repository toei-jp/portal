<?php

namespace App\Responder;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Collection;

/**
 * Schedule responder
 */
class ScheduleResponder extends BaseResponder
{
    /**
     * showing
     *
     * @param Response   $response
     * @param Collection $data
     * @return Response
     */
    public function showing(Response $response, Collection $data)
    {
        return $this->view->render($response, 'schedule/showing.html.twig', $data->all());
    }

    /**
     * soon
     *
     * @param Response   $response
     * @param Collection $data
     * @return Response
     */
    public function soon(Response $response, Collection $data)
    {
        return $this->view->render($response, 'schedule/soon.html.twig', $data->all());
    }
}
