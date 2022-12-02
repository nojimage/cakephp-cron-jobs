<?php
/*
 * Copyright 2022 ELASTIC Consultants Inc.
 */
declare(strict_types=1);

use Elastic\CronJobs\Schedule\CakeSchedule;

$schedule = new CakeSchedule();

$schedule
    ->run('touch tmp/crunz-time')
    ->description('Demo Task')
    ->cron('* * * * *');

return $schedule;
