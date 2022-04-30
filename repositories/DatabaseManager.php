<?php

class DatabaseManager
{
    private static $instance = null;

    private const HOST = 'mysqlstudenti.litv.sssvt.cz';
    private const DBNAME = '4b1_kopeckymichal_db1';
    private const USER = 'kopeckymichal';
    private const PASSWORD = '123456';

    private $conn;

    public static function get_instance()
    {
        if (self::$instance == null) {
            self::$instance = new DatabaseManager();
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