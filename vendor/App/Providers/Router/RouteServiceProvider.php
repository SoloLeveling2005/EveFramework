<?php

namespace Clarity\Providers\Router;

class RouteServiceProvider{
    public static $routes = [];
    public function routes($action) {
        $action();
    }
}