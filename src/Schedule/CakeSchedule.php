<?php
/*
 * Copyright 2022 ELASTIC Consultants Inc.
 */
declare(strict_types=1);

namespace Elastic\CronJobs\Schedule;

use Crunz\Event;
use Crunz\Schedule;

/**
 * \Crunz\Schedule wrapper
 *
 * Run cake shell commands
 */
class CakeSchedule extends Schedule
{
    /**
     * Add a new event as a CakePHP command to the schedule object.
     *
     * @param string $command a CakePHP's Command/Shell name
     * @param array<string> $parameters command arguments and options
     * @return \Crunz\Event
     */
    public function runCommand(string $command, array $parameters = []): Event
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
