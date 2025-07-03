<?php

class Database
{
    private static $instance = null;

    public function __construct() {}
    public function __clone() {}
    public function __wakeup() {}

    public static function getInstance()
    {
        if (self::$instance === null) {
            $host = DB_HOST;
            $database = DB_NAME;
            $user = DB_USER;
            $password = DB_PASS;
            $charset = DB_CHARSET;

            $dsn = "mysql:host=$host;dbname=$database;charset=$charset";
            $options = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_AUTOCOMMIT => 1,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
            );

            try {
                self::$instance = new PDO($dsn, $user, $password, $options);
            } catch (PDOException $e) {
                die("Erro na conexão: " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}
