<?php

//namespace Clarity\Support;

class Env {
    private $data;
    function __construct() {
        $env_data = file_get_contents('.env');

        foreach (explode("\n", $env_data) as $env_line) {
            $env_line = rtrim(ltrim($env_line));
            $this->data[explode('=',$env_line)[0]] = explode('=',$env_line)[1];
        }
    }
    public function env($key, $default) {
        return $this->data[$key] ?? $default;
    }
}
$env_instance = new Env();
function env($key, $default) {
    global $env_instance;
    return $env_instance->env($key, $default);
}