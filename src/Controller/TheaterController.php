<?php

declare(strict_types=1);

namespace App\Controller;

use App\ORM\Entity;
use Slim\Exception\NotFoundException;
use Slim\Http\Request;
use Slim\Http\Response;

class TheaterController extends BaseController
{
    /** @var Entity\Theater $theater */
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
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     * @return void
     */
    protected function preExecute(Request $request, Response $response, array $args): void
    {
        $theater = $this->getTheater($args['name']);

        if (is_null($theater)) {
            throw new NotFoundException($request, $response);
        }

        $this->theater = $theater;

        parent::preExecute($request, $response, $args);
    }

    /**
     * index action
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     * @return Response
     */
    public function executeIndex(Request $request, Response $response, array $args): Response
    {
        $mainBanners = $this->getMainBanners($this->theater);

        $topics = $this->getTopics($this->theater, 3);

        return $this->render($response, 'theater/index.html.twig', [
            'theater' => $this->theater,
            'mainBanners' => $mainBanners,
            'topics' => $topics,
        ]);
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
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     * @return Response
     */
    public function executeTopicList(Request $request, Response $response, array $args): Response
    {
        $topics = $this->getTopics($this->theater);

        return $this->render($response, 'theater/topic/list.html.twig', [
            'theater' => $this->theater,
            'topics' => $topics,
        ]);
    }

    /**
     * topic detail action
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     * @return Response
     */
    public function executeTopicDetail(Request $request, Response $response, array $args): Response
    {
        $topic = $this->getTopic((int) $args['id']);

        if (! $topic) {
            throw new NotFoundException($request, $response);
        }

        return $this->render($response, 'theater/topic/detail.html.twig', [
            'theater' => $this->theater,
            'news' => $topic,
        ]);
    }

    /**
     * return topic
     *
     * @param int $id
     * @return Entity\News|null
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
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     * @return Response
     */
    public function executeAdvanceTicket(Request $request, Response $response, array $args): Response
    {
        $advanceTicketList = $this->getAdvanceTicketList($this->theater);

        return $this->render($response, 'theater/advance_ticket/index.html.twig', [
            'theater' => $this->theater,
            'advanceTicketList' => $advanceTicketList,
        ]);
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
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     * @return Response
     */
    public function executePrice(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, 'theater/price/index.html.twig');
    }

    /**
     * floor guide action
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     * @return Response
     */
    public function executeFloorGuide(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, 'theater/floor_guide/index.html.twig');
    }

    /**
     * access action
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     * @return Response
     */
    public function executeAccess(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, 'theater/access/index.html.twig');
    }
}
