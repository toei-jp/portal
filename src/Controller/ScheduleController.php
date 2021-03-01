<?php

declare(strict_types=1);

namespace App\Controller;

use App\ORM\Entity;
use Slim\Http\Request;
use Slim\Http\Response;

class ScheduleController extends GeneralController
{
    /**
     * showing action
     *
     * @param array<string, mixed> $args
     */
    public function executeShowing(Request $request, Response $response, array $args): Response
    {
        $schedules = $this->getShowingSchedules();

        return $this->render($response, 'schedule/showing.html.twig', ['schedules' => $schedules]);
    }

    /**
     * @return Entity\Schedule[]
     */
    protected function getShowingSchedules(): array
    {
        return $this->em
            ->getRepository(Entity\Schedule::class)
            ->findShowing();
    }

    /**
     * soon action
     *
     * @param array<string, mixed> $args
     */
    public function executeSoon(Request $request, Response $response, array $args): Response
    {
        $schedules = $this->getSoonSchedules();

        return $this->render($response, 'schedule/soon.html.twig', ['schedules' => $schedules]);
    }

    /**
     * @return Entity\Schedule[]
     */
    protected function getSoonSchedules(): array
    {
        return $this->em
            ->getRepository(Entity\Schedule::class)
            ->findSoon();
    }
}
