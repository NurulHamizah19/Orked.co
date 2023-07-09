<?php
namespace Database;

class Database {
    private static $instance = null;

    private function __construct() {
        
        $host = 'localhost';
        $db_name = 'orked-db';
        $username = 'root';
        $password = $dbPass;

        try {
            self::$instance = new \PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
            self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit;
        }
    }

    public function migrate($sqlFile) {
        $truncateTables = "SET FOREIGN_KEY_CHECKS = 0;";
        $truncateTables .= "SHOW TABLES;";
        $tables = $this->getInstance()->query($truncateTables)->fetchAll(\PDO::FETCH_COLUMN);
    
        foreach ($tables as $table) {
            $truncateQuery = "TRUNCATE TABLE $table;";
            $this->getInstance()->exec($truncateQuery);
            echo "Table $table truncated successfully.<br>";
        }
    
        $sql = file_get_contents($sqlFile);
        $statements = explode(';', $sql);
    
        foreach ($statements as $statement) {
            if (trim($statement) === '') {
                continue;
            }
    
            try {
                $this->getInstance()->exec($statement);
                echo "Statement executed successfully: " . $statement . "<br>";
            } catch (\PDOException $e) {
                echo "Error executing statement: " . $e->getMessage() . "<br>";
            }
        }
    }
    

    public static function getInstance() {
        if (!self::$instance) {
            new self();
        }

        return self::$instance;
    }
}
