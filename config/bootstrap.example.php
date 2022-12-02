<?php
/**
 * Copyright 2019 ELASTIC Consultants Inc.
 */

/**
 * This is example register job in bootstrap.php
 */
use Cake\Event\Event;
use Cake\Event\EventManager;

EventManager::instance()->on('CronJobs.buildSchedule', static function (Event $event) {
    /** @type \Elastic\CronJobs\Schedule\CakeSchedule $schedule */
    $schedule = $event->getSubject();

    $schedule->run('touch tmp/crunz-time-from-event')
        ->description('デモ')
        ->cron('* * * * *')->everyDay()->at('09:00');
});
