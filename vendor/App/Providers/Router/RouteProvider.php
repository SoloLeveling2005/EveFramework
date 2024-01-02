<?php

namespace Clarity\Providers\Router;

use Clarity\Http\Middleware\Middleware;
use Clarity\Providers\Router\RouteServiceProvider;

class RouteProvider {
    protected $middleware = null;
    protected $prefix = null;
    protected $groupPath = null;

    protected static $routes = [];

    public static function middleware($middleware) {
        // Определяем тип. Если строка, то это название, иначе класс.

        if (gettype($middleware) == 'string') {
            // Это название.
            $middlewareType = 'string';
        } elseif (is_subclass_of($middleware, Middleware::class)) {
            // Это класс.
            $middlewareType = 'class';
        } else {
            error_log("\033[33m" . "Ошибка в RouteProvider. Несуществующий middleware." . "\033[0m");
            die();
        }

        $instance = new self();
        $instance->middleware = ['middleware'=>$middleware, 'middlewareType'=>$middlewareType];
        return $instance;
    }

    public static function prefix($prefix): RouteProvider
    {
        $prefix = rtrim(ltrim($prefix, '/'), '/');
        $instance = new self();
        $instance->prefix = $prefix;
        return $instance;
    }

    public function group($groupPath): RouteProvider
    {
        $this->groupPath = $groupPath;
        $this->registerRoute();
        return $this;
    }

    protected function registerRoute() {
        RouteServiceProvider::$routes[] = [
            'middleware' => $this->middleware,
            'prefix' => $this->prefix,
            'groupPath' => $this->groupPath,
        ];

        // Сброс данных после регистрации маршрута
        $this->middleware = '';
        $this->prefix = '';
        $this->groupPath = '';
    }

    public static function getRoutes(): array
    {
        return self::$routes;
    }
}