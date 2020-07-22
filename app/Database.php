<?php

class Database {

    protected $db;

    public static function connect () {
        $settings = include_once(__DIR__ . '/../config/config.php');
        $conn = $settings['settings']['connection'];
        $db = new mysqli(
                    $conn['host'] . ":" . $conn['port'], 
                    $conn['user'], 
                    $conn['pwd'],
                    $conn['name'] 
                );
        if ($db === false) {
            die("Could not connect.");
        }

        return $db;
    }
}