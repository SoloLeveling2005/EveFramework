<?php

namespace App\Providers;

use Clarity\Providers\Router\RouteProvider;
use Clarity\Providers\Router\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    // RouteProvider::prefix('')->group(route_path(''));
    /*
    |--------------------------------------------------------------------------
    | Глобальное подключение маршрутов.
    |--------------------------------------------------------------------------
    |
    | По умолчанию система подгружает всю вашу маршрутизацию с папки routes.
    |
    | route_path - метод начинает с папки routes, то есть если вы написали
    | route_path('api') то он будет искать routes/api папку.
    |
    | Однако если вы хотите более точечно настроить маршрутизацию и добавить
    | промежуточное ПО вам понадобится следующее (пример):
    |
    | RouteProvider::middleware('api')->prefix('api/v1')->group('routes/api.php');
    |
    | middleware - метод нужен для подключения промежуточного ПО. Принимает
    | строку (название промежуточного ПО) или сам класс ПО.
    |
    | prefix - используется для добавления общего пути ко всем URL-адресам
    | внутри определенной группы маршрутов.
    |
    | group - путь по которому мы будем искать ваши подключения маршрутов.
    |
    */
    function __construct()
    {
        $this->routes(function () {
            RouteProvider::prefix('api')->group(route_path('api'));
            RouteProvider::prefix('web')->group(route_path('web'));
        });
    }
}