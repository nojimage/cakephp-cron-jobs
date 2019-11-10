<?php
/**
 * Copyright 2019 ELASTIC Consultants Inc.
 */

namespace Elastic\CronJobs\Test\TestCase\Shell;

use Cake\Console\ConsoleIo;
use Cake\Core\Plugin;
use Cake\TestSuite\ConsoleIntegrationTestCase;
use Elastic\CronJobs\Shell\CronJobsShell;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * Elastic\CronJobs\Shell\CronJobsShell Test Case
 */
class CronJobsShellTest extends ConsoleIntegrationTestCase
{
    /**
     * ConsoleIo mock
     *
     * @var ConsoleIo|PHPUnit_Framework_MockObject_MockObject
     */
    public $io;

    /**
     * Test subject
     *
     * @var CronJobsShell
     */
    public $CronJobs;

    /**
     * @var string
     */
    private $tasksPath;

    /**
     * @var string
     */
    private $testFilepath;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->io = $this->getMockBuilder('Cake\Console\ConsoleIo')->getMock();
        $this->CronJobs = new CronJobsShell($this->io);

        $this->tasksPath = Plugin::path('Elastic/CronJobs') . 'tests/Fixture/tasks/';
        $this->testFilepath = Plugin::path('Elastic/CronJobs') . 'tests/tmp/crunz-time';
        if (file_exists($this->testFilepath)) {
            unlink($this->testFilepath);
        }
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CronJobs);

        parent::tearDown();
    }

    /**
     * Test main method
     *
     * @return void
     */
    public function testCanGetScheduleList()
    {
        $this->exec(sprintf('Elastic/CronJobs.CronJobs schedule:list %s', $this->tasksPath));

        $this->assertExitCode(0);
        // TODO: check output
    }

    /**
     * Test main method
     *
     * @return void
     */
    public function testCanScheduleRun()
    {
        $this->exec(sprintf('Elastic/CronJobs.CronJobs schedule:run %s', $this->tasksPath));

        $this->assertExitCode(0);
        $this->assertFileExists($this->testFilepath);
    }
}
