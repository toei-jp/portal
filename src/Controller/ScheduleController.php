<?php

namespace App\Controller;

use App\ORM\Entity;

/**
 * Schedule controller
 */
class ScheduleController extends GeneralController
{
    /**
     * showing action
     *
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     * @param array               $args
     * @return string|void
     */
    public function executeShowing($request, $response, $args)
    {
        $this->data->set('schedules', $this->getShowingSchedules());
    }

    /**
     * return showing schedules
     *
     * @return Entity\Schedule[]
     */
    protected function getShowingSchedules()
    {
        return $this->em
            ->getRepository(Entity\Schedule::class)
            ->findShowing();
    }

    /**
     * soon action
     *
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     * @param array               $args
     * @return string|void
     */
    public function executeSoon($request, $response, $args)
    {
        $this->data->set('schedules', $this->getSoonSchedules());
    }

    /**
     * return soon schedules
     *
     * @return Entity\Schedule[]
     */
    protected function getSoonSchedules()
    {
        return $this->em
            ->getRepository(Entity\Schedule::class)
            ->findSoon();
    }
}
