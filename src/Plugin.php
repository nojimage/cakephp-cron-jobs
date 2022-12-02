<?php
/*
 * Copyright 2022 ELASTIC Consultants Inc.
 */

declare(strict_types=1);

namespace Elastic\CronJobs;

use Cake\Console\CommandCollection;
use Cake\Core\BasePlugin;
use Elastic\CronJobs\Command\CronJobsCommand;

/**
 * Plugin class for CakePHP.
 */
class Plugin extends BasePlugin
{
    /**
     * Do bootstrapping or not
     *
     * @var bool
     */
    protected $bootstrapEnabled = false;

    /**
     * Enable middleware
     *
     * @var bool
     */
    protected $middlewareEnabled = false;

    /**
     * Console middleware
     *
     * @var bool
     */
    protected $consoleEnabled = true;

    public function console(CommandCollection $commands): CommandCollection
    {
        $commands->addMany([
            'cron_jobs' => CronJobsCommand::class,
            // legacy calls
            'Elastic/CronJobs.CronJobs' => CronJobsCommand::class,
            'CronJobs' => CronJobsCommand::class,
        ]);

        return $commands;
    }
}
