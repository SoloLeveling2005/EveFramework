<?php

// Старт приложения

// Импорт ядра
include "vendor/App/App.php";
use Clarity\App;

try {

    // Создаем экземпляр и запускаем
    $app = new App();
    $app->listen('web server');

} catch (Exception $e) {
    print_r($e);
}



