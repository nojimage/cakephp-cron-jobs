<?php
/**
 * Copyright 2019 ELASTIC Consultants Inc.
 */

use Cake\Event\Event;
use Cake\Event\EventManager;
use Elastic\CronJobs\Schedule\CakeSchedule;

$schedule = new CakeSchedule();

$event = new Event('CronJobs.buildSchedule', $schedule);
EventManager::instance()->dispatch($event);

return $schedule;
