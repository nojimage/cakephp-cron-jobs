<?php
/**
 * Copyright 2019 ELASTIC Consultants Inc.
 */

use Elastic\CronJobs\Schedule\CakeSchedule;

$schedule = new CakeSchedule();

$schedule
    ->run('touch tests/tmp/crunz-time')
    ->description('Demo Task')
    ->cron('* * * * *');

return $schedule;
