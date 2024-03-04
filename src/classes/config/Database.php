<?php
class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        $this->openConnection();
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
        if ($this->connection === null) {
            $this->connection = new SQLite3($_SERVER['DOCUMENT_ROOT'] . '/sql/bank.db');
            $this->execute("PRAGMA foreign_keys = ON;"); // Enable foreign key constraints
            if (!$this->connection) {
                throw new Exception("Failed to connect to the database.");
            }
        }
    }

    public function query($sql, $params = [])
    {
        $stmt = $this->prepareStatement($sql, $params);
        $result = $stmt->execute();
        $data = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

    public function execute($sql, $params = [])
    {
        $stmt = $this->prepareStatement($sql, $params);
        $stmt->execute();
        return $this->connection->changes();
    }

    private function prepareStatement($sql, $params)
    {
        $stmt = $this->connection->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value, SQLITE3_TEXT);
        }
        return $stmt;
    }

    private function closeConnection()
    {
        if ($this->connection) {
            $this->connection->close();
            $this->connection = null;
        }
    }

    private function __clone()
    {
        // Prevent cloning of the instance
    }

    public function __wakeup()
    {
        // Prevent unserializing of the instance
    }

    public function __destruct()
    {
        if ($this->connection) {
            $this->closeConnection();
        }
    }
}
