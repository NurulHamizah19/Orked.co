<?php
namespace Database;

class Database {
    private static $instance = null;

    private function __construct() {
        $dbHost = 'localhost';
        $dbName = 'orked-db';
        $dbUser = 'root';
        $dbPass = '';

        $host = $dbHost;
        $db_name = $dbName;
        $username = $dbUser;
        $password = $dbPass;

        try {
            self::$instance = new \PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
            self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit;
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            new self();
        }

        return self::$instance;
    }
}
