<?php
class Database
{
    private static $instance = null;

    private function __construct()
    {
        // Prevent direct instantiation
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function openConnection()
    {
        if (self::$instance === null) {
            self::$instance = new PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/bank.sqlite");
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        return self::$instance;
    }

    private function closeConnection()
    {
        self::$instance = null;
    }

    public function query($sql, $params = [])
    {
        $conn = $this->openConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll();
        $this->closeConnection();
        return $result;
    }

    public function execute($sql, $params = [])
    {
        $conn = $this->openConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->rowCount();
        $this->closeConnection();
        return $result;
    }

    private function __clone()
    {
        // Prevent cloning of the instance
    }

    public function __wakeup()
    {
        // Prevent unserializing of the instance
    }
}
