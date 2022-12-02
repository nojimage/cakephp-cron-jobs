<?php
/*
 * Copyright 2022 ELASTIC Consultants Inc.
 */
declare(strict_types=1);

namespace Elastic\CronJobs\Schedule;

use Crunz\Schedule;

/**
 * \Crunz\Schedule wrapper
 *
 * Run cake shell commands
 */
class CakeSchedule extends Schedule
{
    /**
     * Add a new event as CakePHP command to the schedule object.
     *
     * @param string|\Closure $command a CakePHP's Command/Shell name
     * @param array $parameters command arguments and options
     *
     * @return \Crunz\Event
     */
    public function runCommand($command, array $parameters = []): \Crunz\Event
    {
        return $this->run($this->getCakeCommand() . ' ' . $command, $parameters)
            ->in(escapeshellarg(ROOT));
    }

    /**
     * @return string
     */
    protected function getCakeCommand(): string
    {
        $binDir = 'bin' . DS;

        if (PHP_OS_FAMILY === 'Windows') {
            return $binDir . 'cake.bat';
        }

        return $binDir . 'cake';
    }
}
