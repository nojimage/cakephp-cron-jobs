<?php
/*
 * Copyright 2022 ELASTIC Consultants Inc.
 */
declare(strict_types=1);

use Cake\Cache\Cache;
use Cake\Core\Configure;

/**
 * Test suite bootstrap for CakePHP Plugin.
 *
 * This function is used to find the location of CakePHP whether CakePHP
 * has been installed as a dependency of the plugin, or the plugin is itself
 * installed as a dependency of an application.
 */
$findRoot = function ($root) {
    do {
        $lastRoot = $root;
        $root = dirname($root);
        if (is_dir($root . '/vendor/cakephp/cakephp')) {
            return $root;
        }
    } while ($root !== $lastRoot);

    throw new Exception('Cannot find the root of the application, unable to run tests');
};
$root = $findRoot(__FILE__);
unset($findRoot);

$here = __DIR__;

chdir($root);
require $root . '/vendor/cakephp/cakephp/tests/bootstrap.php';

Cache::clearAll();

error_reporting(E_ALL);

Configure::write('App.namespace', '\TestApp');
