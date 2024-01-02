<?php

namespace Clarity\Routing;

class Route {
    public static $route_list = [];

    public static function parseRoute($route) {
        $parts = explode('/', ltrim(rtrim($route, '/'), '/'));

        $result = [];

        foreach ($parts as $part) {
        if (strpos($part, '{') === 0 && strrpos($part, '}') === strlen($part) - 1) {
            // Динамический параметр в URL
        $paramName = rtrim(trim($part, '{}'), '?');
        $paramType = strpos($part, '?') === strlen($part) - 2 ? 'optional' : 'dynamic';

        $result[] = ['name' => $paramName, 'type' => $paramType];
        } else {
            // Статическая часть URL
            $result[] = ['name' => $part, 'type' => 'static'];
        }
        }

        return $result;
    }

    public function getRoutes(): array {
        return self::$route_list;
    }

    public static function post($url, $action) {
        if (gettype($action) === 'array') {
            $action_type = 'class_method';
        } elseif (is_callable($action)) {
            $action_type = 'function';
        } else {
            error_log("\033[33m" . "Неправильно подан action для маршрута. Допустимо только функция или [класс, 'метод']." . "\033[0m");
            die();
        }

        self::$route_list['POST'][] = [
            'action_type'=>$action_type,
            'action'=>$action,
            'url'=>$url
        ];
    }
    public static function get($url, $action) {
        // Возможные urls
        // /api/v1 => []
        // /api/{version}/
        // /api/{version}
        // /api/{version?}
        if (gettype($action) === 'array') {
            $action_type = 'class_method';
        } elseif (is_callable($action)) {
            $action_type = 'function';
        } else {
            error_log("\033[33m" . "Неправильно подан action для маршрута. Допустимо только функция или [класс, 'метод']." . "\033[0m");
            die();
        }

        $url = self::parseRoute($url);

        self::$route_list['GET'][] = [
            'action_type'=>$action_type,
            'action'=>$action,
            'url'=>$url
        ];
    }

    public function get_route($route_url, $method) {
        $method = strtoupper($method);
        if ($method === 'POST') {
            foreach (self::$route_list['POST'] as $route) {
                if ($route['url'] === $route_url) {
                    return $route;
                }
            }
            return null;
        }
        if ($method === 'GET') {
            foreach (self::$route_list_gets as $route) {
                if ($route['url'] === $route_url) {
                    return $route;
                }
            }
            return null;
        }
    }
}