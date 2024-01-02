<?php

namespace Clarity\Settings;

// Классы помощники
include 'vendor/App/Support/DirectoryPath.php';
include 'vendor/App/Support/Env.php';

class Config {
    public $DB;
    public $VIEW;
    public $FILESYSTEMS;

    function __construct()
    {
        $this->DB = require('config/database.php');
        $this->VIEW = require('config/view.php');
        $this->FILESYSTEMS = require('config/filesystems.php');
    }
}