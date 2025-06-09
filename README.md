# A cron job runner for CakePHP

<p align="center">
    <a href="LICENSE.txt" target="_blank">
        <img alt="Software License" src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square">
    </a>
    <a href="https://github.com/nojimage/cakephp-cron-jobs/actions" target="_blank">
        <img alt="Build Status" src="https://img.shields.io/github/actions/workflow/status/nojimage/cakephp-cron-jobs/ci.yml?style=flat-square">
    </a>
    <a href="https://codecov.io/gh/nojimage/cakephp-cron-jobs" target="_blank">
        <img alt="Codecov" src="https://img.shields.io/codecov/c/github/nojimage/cakephp-cron-jobs.svg?style=flat-square">
    </a>
    <a href="https://packagist.org/packages/elstc/cakephp-cron-jobs" target="_blank">
        <img alt="Latest Stable Version" src="https://img.shields.io/packagist/v/elstc/cakephp-cron-jobs.svg?style=flat-square">
    </a>
</p>

This plugin is a simple wrapper for [crunzphp/crunz](https://github.com/crunzphp/crunz).

## Version Map

| CakePHP Version | Plugin Version | Branch         |
|-----------------|----------------|----------------|
| 5.x             | 3.x            | cake5          |
| 4.x             | 2.x            | cake4          |
| 3.x             | 0.3.x          | cake3          |

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
The command generates `crunz.yml` in the project `ROOT` directory.

You can configure it with `crunz.yml`, see also [https://github.com/crunzphp/crunz#configuration](https://github.com/crunzphp/crunz#configuration)

I recommend changing `source:` to:

```yaml
source: vendor/elstc/cakephp-cron-jobs/tasks
```

This makes it unnecessary to specify a directory when using `schedule:run` and `schedule:list` command.

### Register to cron

Add your cron schedule using `crontab -e`:

```
* * * * * cd {YOUR-APP-DIR}; bin/cake CronJobs schedule:run vendor/elstc/cakephp-cron-jobs/tasks/
```

## Usage

You can register a scheduled job from the CakePHP event system.

Register to job scheduler in bootstrap_cli.php using the CakePHP event system:

```php
use Cake\Event\Event;
use Cake\Event\EventManager;

EventManager::instance()->on('CronJobs.buildSchedule', static function (Event $event) {
    /** @type \Elastic\CronJobs\Schedule\CakeSchedule $schedule */
    $schedule = $event->getSubject();

    // Add a scheduled command
    $schedule->run('touch tmp/crunz-time-from-event')
        ->description('your job description')
        ->everyDay()
        ->at('09:00');

    // Add a scheduled cake's command
    // such as `bin/cake your_command command_arg1 --command-option --some-opt=value`
    $schedule->runCommand('your_command', [
            'command_arg1',
            '--command-option',
            '--some-opt' => 'value',
        ])
        ->description('your job description')
        ->cron('0 3 * * *');
});
```

`\Elastic\CronJobs\Schedule\CakeSchedule` is a `\Crunz\Schedule` wrapper class.
See also: [crunzphp/crunz README](https://github.com/crunzphp/crunz#crunz)

### Show scheduled jobs

```sh
bin/cake CronJobs schedule:list vendor/elstc/cakephp-cron-jobs/tasks/
```

### Upgrade from CakePHP 3

crunzphp/crunz updated from 1.12 to 2.x (<= PHP 7.3), 3.x (>= PHP 7.4). See also crunz's Upgrade Guide.

[crunz/UPGRADE\.md at master · crunzphp/crunz](https://github.com/crunzphp/crunz/blob/master/UPGRADE.md)
