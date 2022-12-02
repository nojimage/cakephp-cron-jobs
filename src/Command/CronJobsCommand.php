<?php
/*
 * Copyright 2022 ELASTIC Consultants Inc.
 */
declare(strict_types=1);

namespace Elastic\CronJobs\Command;

use Cake\Console\Arguments;
use Cake\Console\BaseCommand;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Crunz\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * CronJobs command.
 *
 * A simple crunz's cli application wrapper.
 */
class CronJobsCommand extends BaseCommand
{
    /**
     * initialize
     *
     * @return void
     */
    public function initialize(): void
    {
        if (!defined('CRUNZ_BIN')) {
            define('CRUNZ_BIN', ROOT . '/vendor/bin/crunz');
        }
        if (!defined('CRUNZ_VERSION')) {
            define('CRUNZ_VERSION', '3.0.1');
        }

        parent::initialize();
    }

    /**
     * bypass to Crunz
     *
     * {@inheritDoc}
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $app = $this->getApp();
        $app->setAutoExit(false);

        return $app->run($this->getInput($args), $this->getOutput());
    }

    /**
     * Returns the Crunz\Application the Command will have to use
     *
     * @return \Crunz\Application
     */
    protected function getApp(): Application
    {
        return new Application('CakePHP Cron Scheduler via Crunz', CRUNZ_VERSION);
    }

    /**
     * Returns the instance of ArgvInput the Crunz\Application will have to use.
     *
     * @param Arguments $args the command args
     * @return \Symfony\Component\Console\Input\InputInterface
     */
    protected function getInput(Arguments $args): InputInterface
    {
        $argv = $args->getArguments();
        // bypass to the symfony application
        array_unshift($argv, 'crunz');

        return new ArgvInput($argv);
    }

    /**
     * Returns the instance of OutputInterface the Crunz\Application will have to use.
     *
     * @return \Symfony\Component\Console\Output\OutputInterface
     */
    protected function getOutput(): OutputInterface
    {
        return new ConsoleOutput();
    }

    /**
     * Output help content
     *
     * @param \Cake\Console\ConsoleOptionParser $parser The option parser.
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return void
     */
    protected function displayHelp(ConsoleOptionParser $parser, Arguments $args, ConsoleIo $io): void
    {
        $this->execute($args, $io);
    }
}
