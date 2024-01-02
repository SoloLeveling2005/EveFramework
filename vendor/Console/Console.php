<?php

namespace Clarity;

class Console {
    private $commands = [
        "migrate"=>"migrate",
        "migrate:fresh"=>"migrate_fresh",
    ];
    function __construct($argc, $argv) {
        print_r($argv);
        if (isset($argv[1])) {
            if (isset($this->commands[$argv[1]])) {
                return $this->{$this->commands[$argv[1]]}();
            }
        }
        error_log("\033[33m" . "Введите help чтобы узнать существующие команды." . "\033[0m");
    }
    public function migrate() {
        // Импорт схем (Scheme) и их запуск в консоль режиме.

    }
    private function migrate_fresh() {

    }
}