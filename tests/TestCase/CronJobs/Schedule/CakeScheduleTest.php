<?php

namespace Elastic\Test\TestCase\CronJobs\Schedule;

use Cake\TestSuite\TestCase;
use Elastic\CronJobs\Schedule\CakeSchedule;

class CakeScheduleTest extends TestCase
{
    /**
     * can build cake shell command
     */
    public function testRunCommand()
    {
        $schedule = new CakeSchedule();
        $result = $schedule->runCommand('example_task', ['with-arg']);

        // Can add event
        $this->assertCount(1, $schedule->events());
        $this->assertSame('bin/cake example_task with-arg', $result->getCommand());
        $this->assertSame(sprintf("'%s'", ROOT), $result->getWorkingDirectory());
    }
}
