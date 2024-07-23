<?php
// app/models/database.php
$a = 1;
class Database{
    private static $instance = null;
    private $conn; //объект подключения к базе данных

// объект подключения к базе данных
    private function __construct()
    {
        $config = require_once __DIR__ . '/../../config.php';
        $db_host = $config['db_host'];
        $db_user = $config['db_user'];
        $db_pass = $config['db_pass'];
        $db_name = $config['db_name'];
        //https://youtu.be/8kle1jzL954?list=PLMB6wLyKp7lXH2UwgDNTbeGlLNFvX1QcV&t=613
        try {
            $dsn = "mysql:host=$db_host;dbname=$db_name";
            $this->conn = new PDO($dsn, $db_user, $db_pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            echo 'Connect filed: ' . $e->getMessage();
        }
    }



    // возвращает сам объект класса database
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // метод возвращает объект подключения
    public function getConnection()
    {
        return $this->conn;
    }
}