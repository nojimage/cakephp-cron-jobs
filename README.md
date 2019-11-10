# A cron job runner for CakePHP 3.x

<p align="center">
    <a href="LICENSE.txt" target="_blank">
        <img alt="Software License" src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square">
    </a>
    <a href="https://travis-ci.org/nojimage/cakephp-cron-jobs" target="_blank">
        <img alt="Build Status" src="https://img.shields.io/travis/nojimage/cakephp-cron-jobs/master.svg?style=flat-square">
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

(CakePHP >= 3.6.0) Load the plugin by adding the following statement in your project's `src/Application.php`:

```
$this->addPlugin('Elastic/CronJobs');
```

(CakePHP <= 3.5.x) Load the plugin by adding the following statement in your project's `config/bootstrap.php` file:

```
Plugin::load('Elastic/CronJobs');
```

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
    $schedule = $event->getSubject();
    /* @var $schedule \Elastic\CronJobs\Schedule\CakeSchedule */
    
    // Add scheduled shell command
    $schedule->run('touch tmp/crunz-time-from-event')
        ->description('your job description')
        ->everyDay()
        ->at('09:00');

    // Add scheduled cake's shell command
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
