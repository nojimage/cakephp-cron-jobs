# A cron job runner for CakePHP

<p align="center">
    <a href="LICENSE.txt" target="_blank">
        <img alt="Software License" src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square">
    </a>
    <a href="https://github.com/nojimage/cakephp-cron-jobs/actions" target="_blank">
        <img alt="Build Status" src="https://img.shields.io/github/workflow/status/nojimage/cakephp-cron-jobs/CakePHP%20Plugin%20CI/cake4?style=flat-square">
    </a>
    <a href="https://codecov.io/gh/nojimage/cakephp-cron-jobs" target="_blank">
        <img alt="Codecov" src="https://img.shields.io/codecov/c/github/nojimage/cakephp-cron-jobs.svg?style=flat-square">
    </a>
    <a href="https://packagist.org/packages/elstc/cakephp-cron-jobs" target="_blank">
        <img alt="Latest Stable Version" src="https://img.shields.io/packagist/v/elstc/cakephp-cron-jobs.svg?style=flat-square">
    </a>
</p>

This plugin is simple wrapper [lavary/crunz](https://github.com/lavary/crunz).


## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require elstc/cakephp-cron-jobs
```

### Load plugin

Load the plugin by adding the following statement in your project's `src/Application.php`:

```
$this->addPlugin('Elastic/CronJobs');
```

### Generate config file

Run `bin/cake CronJobs publish:config` command.
The command generate `crunz.yml` in the project `ROOT` directory.

You can configure with `crunz.yml`, see also [https://github.com/lavary/crunz#configuration](https://github.com/lavary/crunz#configuration)

I recommend changing `source:` to:

```yaml
source: vendor/elstc/cakephp-cron-jobs/tasks
```

This makes it unnecessary to specify a directory when using `schedule:run` and `schedule:list` command.

### Register to cron

add your cron schedule, use `crontab -e`

```
* * * * * cd {YOUR-APP-DIR}; bin/cake CronJobs schedule:run vendor/elstc/cakephp-cron-jobs/tasks/
```

## Usage

You can register a schedule job from the CakePHP event system.

Register to job schduler in bootstrap_cli.php, using cakephp event system:

```php
use Cake\Event\Event;
use Cake\Event\EventManager;

EventManager::instance()->on('CronJobs.buildSchedule', static function (Event $event) {
    /** @type \Elastic\CronJobs\Schedule\CakeSchedule $schedule */
    $schedule = $event->getSubject();
    
    // Add scheduled command
    $schedule->run('touch tmp/crunz-time-from-event')
        ->description('your job description')
        ->everyDay()
        ->at('09:00');

    // Add scheduled cake's command
    // such as `bin/cake your_command comannd_arg1 --command-option --some-opt=value`
    $schedule->runCommand('your_command', [
            'comannd_arg1',
            '--command-option',
            '--some-opt' => 'value',
        ])
        ->description('your job description')
        ->cron('0 3 * * *');
});
```

`\Elastic\CronJobs\Schedule\CakeSchedule` is `\Crunz\Schedule` wrapper class.
See also: [lavary/crunz README](https://github.com/lavary/crunz#crunz)

### Show scheduled jobs

```sh
bin/cake CronJobs schedule:list vendor/elstc/cakephp-cron-jobs/tasks/
```

### Upgrade from CakePHP 3

larvery/crunz updated from 1.12 to 2.x(<= PHP 7.3), 3.x(>= PHP 7.4), See also crunz's Upgrade Guide.

[crunz/UPGRADE\.md at master · lavary/crunz](https://github.com/lavary/crunz/blob/master/UPGRADE.md)
