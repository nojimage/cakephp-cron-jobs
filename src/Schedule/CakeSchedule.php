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
        return $this->run(escapeshellarg($this->getCakeCommand()) . ' ' . $command, $parameters);
    }

    /**
     * @return string
     */
    protected function getCakeCommand()
    {
        $binDir = ROOT . DS . 'bin' . DS;

        if (0 === strpos(strtoupper(PHP_OS), 'WIN')) {
            return $binDir . 'cake.bat';
        }

        return $binDir . 'cake';
    }
}
