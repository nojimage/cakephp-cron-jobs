<?php
/**
 * Copyright 2019 ELASTIC Consultants Inc.
 */

namespace Elastic\CronJobs\Shell;

use Cake\Console\Shell;
use Crunz\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * CronJobs shell command.
 *
 * A simple crunz's cli application wrapper.
 */
class CronJobsShell extends Shell
{
    /**
     * @var array
     */
    private $argv;

    /**
     * initialize
     *
     * @return void
     */
    public function initialize()
    {
        if (!defined('CRUNZ_BIN')) {
            define('CRUNZ_BIN', ROOT . '/vendor/bin/crunz');
        }
        // NOTE: Remove in crunz v2
        if (!defined('CRUNZ_BIN_DIR')) {
            define('CRUNZ_BIN_DIR', dirname(CRUNZ_BIN));
        }
        if (!defined('CRUNZ_VERSION')) {
            define('CRUNZ_VERSION', '1.12.2');
        }

        parent::initialize();
    }

    /**
     * Override the default behavior to save the command called
     * in order to pass it to the command dispatcher
     *
     * {@inheritDoc}
     */
    public function runCommand($argv, $autoMethod = false, $extra = [])
    {
        array_unshift($argv, 'crunz');
        $this->argv = $argv;

        return parent::runCommand($argv, $autoMethod, $extra);
    }

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     * @throws \Exception
     */
    public function main()
    {
        $app = $this->getApp();

        $input = new ArgvInput($this->argv);
        $app->setAutoExit(false);

        $exitCode = $app->run($input, $this->getOutput());

        return $exitCode === 0;
    }

    /**
     * Returns the MigrationsDispatcher the Shell will have to use
     *
     * @return \Crunz\Application
     */
    private function getApp()
    {
        return new Application('CakePHP Cron Scheduler via Crunz', CRUNZ_VERSION);
    }

	/**
     * Returns the instance of OutputInterface the MigrationsDispatcher will have to use.
     *
     * @return \Symfony\Component\Console\Output\ConsoleOutput
     */
    private function getOutput()
    {
        return new ConsoleOutput();
    }

    /**
     * Display the help in the correct format
     *
     * @param string $command The command to get help for.
     * @return int|bool|null Exit code or number of bytes written to stdout
     * @throws \Exception
     */
    protected function displayHelp($command)
    {
        return $this->main();
    }

    /**
     * {@inheritDoc}
     * @throws \Exception
     */
    // @codingStandardsIgnoreStart
    protected function _displayHelp($command)
    {
        // @codingStandardsIgnoreEnd
        return $this->displayHelp($command);
    }
}
