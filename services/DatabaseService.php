<?php

class DatabaseService
{
    private static $instance = null;

    private const HOST = 'localhost';
    private const DBNAME = 'phpnews';
    private const USER = 'root';
    private const PASSWORD = '';

    private $conn;

    public static function get_instance()
    {
        if (self::$instance == null) {
            self::$instance = new DatabaseService();
        }

        return self::$instance;
    }

    public function __construct()
    {
        $this->conn = new PDO(
            'mysql:host=' . self::HOST . ';dbname=' . self::DBNAME, self::USER, self::PASSWORD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        $this->conn->query('SET NAMES utf8');
    }

    public function select($sql, $params = [])
    {
        $stmt = $this->execute($sql, $params);
        return $stmt->fetchAll();
    }

    public function selectOne($sql, $params = [])
    {
        $stmt = $this->execute($sql, $params);
        return $stmt->fetch();
    }

    public function insert($sql, $params = [])
    {
        $stmt = $this->execute($sql, $params);
        return $this->conn->lastInsertId();
    }

    public function update($sql, $params = [])
    {
        $stmt = $this->execute($sql, $params);
        return $stmt->rowCount();
    }

    public function delete($sql, $params = [])
    {
        $this->execute($sql, $params);
        return $this->conn->lastInsertId();
    }

    public function exists($sql, $params = [])
    {
        $stmt = $this->execute($sql, $params);
        return $stmt->rowCount() > 0;
    }

    private function execute($sql, $params = [])
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}