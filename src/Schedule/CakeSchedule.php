<?php
/**
 * Copyright 2019 ELASTIC Consultants Inc.
 */

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
    public function runCommand($command, array $parameters = [])
    {
        return $this->run($this->getCakeCommand() . ' ' . $command, $parameters)
            ->in(escapeshellarg(ROOT));
    }

    /**
     * @return string
     */
    protected function getCakeCommand()
    {
        $binDir = 'bin' . DS;

        if (0 === strpos(strtoupper(PHP_OS), 'WIN')) {
            return $binDir . 'cake.bat';
        }

        return $binDir . 'cake';
    }
}
