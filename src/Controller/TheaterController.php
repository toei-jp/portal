<?php

/**
 * TheaterController.php
 *
 * @author Atsushi Okui <okui@motionpicture.jp>
 */

namespace Toei\Portal\Controller;

use Slim\Exception\NotFoundException;
use Toei\Portal\ORM\Entity;

/**
 * Theater controller
 */
class TheaterController extends BaseController
{
    /**@var Entity\Theater $theater */
    protected $theater;

    /**
     * find by entity
     *
     * @param string $name
     * @return Entity\Theater|null
     */
    protected function getTheater(string $name)
    {
        return $this->em
            ->getRepository(Entity\Theater::class)
            ->findOneByName($name);
    }

    /**
     * pre execute
     *
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     * @param array               $args
     * @return void
     */
    protected function preExecute($request, $response, $args): void
    {
        if (! isset($args['name']) || empty($args['name'])) {
            throw new NotFoundException($request, $response);
        }

        $theaterName   = $args['name'];
        $this->theater = $this->getTheater($theaterName);

        if (is_null($this->theater)) {
            throw new NotFoundException($request, $response);
        }

        $this->data->set('theater', $this->theater);

        parent::preExecute($request, $response, $args);
    }

    /**
     * index action
     *
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     * @param array               $args
     * @return string|void
     */
    public function executeIndex($request, $response, $args)
    {
        $this->data->set('mainBanners', $this->getMainBanners($this->theater));

        $this->data->set('topics', $this->getTopics($this->theater, 3));
    }

    /**
     * return main_banners
     *
     * @param Entity\Theater $theater
     * @return Entity\MainBanner[]
     */
    protected function getMainBanners(Entity\Theater $theater)
    {
        return $this->em
            ->getRepository(Entity\MainBanner::class)
            ->findByTheaterId($theater->getId());
    }

    /**
     * return topics
     *
     * @param Entity\Theater $theater
     * @param int|null       $limit
     * @return Entity\News[]
     */
    protected function getTopics(Entity\Theater $theater, ?int $limit = null)
    {
        return $this->em
            ->getRepository(Entity\News::class)
            ->findByTheater($theater->getId(), [Entity\News::CATEGORY_TOPICS], $limit);
    }

    /**
     * topic list action
     *
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     * @param array               $args
     * @return string|void
     */
    public function executeTopicList($request, $response, $args)
    {
        $this->data->set('topics', $this->getTopics($this->theater));
    }

    /**
     * topic detail action
     *
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     * @param array               $args
     * @return string|void
     */
    public function executeTopicDetail($request, $response, $args)
    {
        if (! isset($args['id']) || empty($args['id'])) {
            throw new NotFoundException($request, $response);
        }

        $id = (int) $args['id'];

        $this->data->set('news', $this->getTopic($id));
    }

    /**
     * return topic
     *
     * @param int $id
     * @return Entity\News
     */
    protected function getTopic(int $id)
    {
        return $this->em
            ->getRepository(Entity\News::class)
            ->findOneById($id);
    }

    /**
     * advance ticket action
     *
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     * @param array               $args
     * @return string|void
     */
    public function executeAdvanceTicket($request, $response, $args)
    {
        $this->data->set('advanceTicketList', $this->getAdvanceTicketList($this->theater));
    }

    /**
     * return advance ticket list
     *
     * @param Entity\Theater $theater
     * @return Entity\AdvanceTicket[]
     */
    protected function getAdvanceTicketList(Entity\Theater $theater)
    {
        return $this->em
            ->getRepository(Entity\AdvanceTicket::class)
            ->findByTheater($theater->getId());
    }

    /**
     * price action
     *
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     * @param array               $args
     * @return string|void
     */
    public function executePrice($request, $response, $args)
    {
    }

    /**
     * floor guide action
     *
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     * @param array               $args
     * @return string|void
     */
    public function executeFloorGuide($request, $response, $args)
    {
    }

    /**
     * access action
     *
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     * @param array               $args
     * @return string|void
     */
    public function executeAccess($request, $response, $args)
    {
    }
}
