<?php
/*
 * Copyright 2022 ELASTIC Consultants Inc.
 */
declare(strict_types=1);

namespace Elastic\CronJobs\Test\TestCase\Command;

use Cake\Console\ConsoleIo;
use Cake\Core\Plugin;
use Cake\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Elastic\CronJobs\Command\CronJobsCommand;

/**
 * Elastic\CronJobs\Shell\CronJobsShell Test Case
 */
class CronJobsCommandTest extends TestCase
{
    use ConsoleIntegrationTestTrait;

    /**
     * ConsoleIo mock
     *
     * @var ConsoleIo|\PHPUnit\Framework\MockObject\MockObject
     */
    public $io;

    /**
     * Test subject
     *
     * @var CronJobsCommand
     */
    public $CronJobs;

    /**
     * @var string
     */
    private $_cwd;

    /**
     * @var string
     */
    private $testAppRoot;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->useCommandRunner();

        $this->io = $this->getMockBuilder(ConsoleIo::class)->getMock();
        $this->CronJobs = new CronJobsCommand();

        // change working directory to test app root
        $this->_cwd = getcwd();
        $this->testAppRoot = Plugin::path('Elastic/CronJobs') . 'tests/test_app';
        chdir($this->testAppRoot);

        if (file_exists($this->testAppRoot . '/tmp/crunz-time')) {
            unlink($this->testAppRoot . '/tmp/crunz-time');
        }
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CronJobs);
        chdir($this->_cwd);

        parent::tearDown();
    }

    /**
     * Test main method
     *
     * @return void
     */
    public function testCanGetScheduleList(): void
    {
        $this->exec('Elastic/CronJobs.CronJobs schedule:list');

        $this->assertExitCode(0);
    }

    /**
     * Test main method
     *
     * @return void
     */
    public function testCanScheduleRun(): void
    {
        $this->exec('Elastic/CronJobs.CronJobs schedule:run');

        $this->assertExitCode(0);
        $this->assertFileExists($this->testAppRoot . '/tmp/crunz-time');
    }

    /**
     * Test bypass to crunz application
     *
     * @return void
     */
    public function testCanBypassCommand(): void
    {
        $this->exec('cron_jobs help make:task');

        $this->assertExitCode(0);
    }
}
