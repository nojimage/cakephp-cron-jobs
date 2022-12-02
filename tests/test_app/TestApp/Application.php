<?php
/*
 * Copyright 2022 ELASTIC Consultants Inc.
 */

namespace TestApp;

use Cake\Http\BaseApplication;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\RouteBuilder;

class Application extends BaseApplication
{
    public function bootstrap(): void
    {
        $this->addPlugin('Elastic/CronJobs');
    }

    public function middleware(MiddlewareQueue $middleware): MiddlewareQueue
    {
        return $middleware;
    }

    public function routes(RouteBuilder $routes): void
    {
        // this plugin not provide routing
    }
}
