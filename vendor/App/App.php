<?php

namespace Clarity;

// Конфигурация
include "vendor/App/Settings/Config.php";

// Рутинг
include 'vendor/App/Routing/Route.php';

use Clarity\Routing\Route;
use Clarity\Settings\Config;

// Консоль
include "vendor/Console/Console.php";
use Clarity\Console;

// Providers
include "vendor/App/Providers/Router/RouteServiceProvider.php";
include "vendor/App/Providers/Router/RouteProvider.php";
use App\Providers\RouteServiceProvider;


class App {
    function __construct() {
    }

    function listen($type) {
        $config = new Config();
//        print_r($config);

        // Проверяем. Какой тип запроса пришел. Запрос с сервера или консоль команда.

        // Подключаем модели и миграции.
        // Подключаем контроллеры.
        // Подключаем пути.


        // Активируем провайдеры
        include 'app/Providers/RouteServiceProvider.php';

        $route_service_provider = new RouteServiceProvider();

        // Импорт указанного роутинга
        foreach ($route_service_provider::$routes as $route) {
            // Получаем список файлов и директорий в указанной директории
            if (file_exists($route['groupPath'])) {
                $files = scandir($route['groupPath']);
            } else {
                error_log("\033[33m" . "Директория/файл указан неверно или не существует." . "\033[0m");
                die();
            }

            $phpFiles = [];
            // Оставляем только файлы
            foreach ($files as $file) {
                if (is_file($route['groupPath'].'/'.$file)) {
                    $phpFiles[] = $route['groupPath'].'/'.$file;
                    // Сразу подключаем файлы
                    include $route['groupPath'].'/'.$file;
                }
            }

        }
        print_r(Route::$route_list);
        return;

        // Был запуск через консоль.
        global $argc, $argv;
        if ($type=='console') {
            $console = new Console($argc, $argv);
            return;
        }



    }
}