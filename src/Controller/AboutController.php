<?php

/**
 * AboutController.php
 *
 * @author Atsushi Okui <okui@motionpicture.jp>
 */

namespace Toei\Portal\Controller;

use Toei\Portal\ORM\Entity;

/**
 * About controller
 */
class AboutController extends GeneralController
{
    /**
     * faq action
     *
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     * @param array               $args
     * @return string|void
     */
    public function executeFaq($request, $response, $args)
    {
    }
    
    /**
     * law action
     *
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     * @param array               $args
     * @return string|void
     */
    public function executeLaw($request, $response, $args)
    {
    }
}
