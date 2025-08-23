<?php
class Database {
    private static $instance = null;
    private $pdo;

    private function __construct($config) {
        $this->pdo = new PDO(
            "mysql:host={$config['host']};dbname={$config['name']};charset=utf8mb4",
            $config['user'],
            $config['pass']
        );
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance($config) {
        if (self::$instance === null) {
            self::$instance = new Database($config);
        }
        return self::$instance->pdo;
    }
}
