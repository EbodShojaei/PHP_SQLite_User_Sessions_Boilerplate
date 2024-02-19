<?php

/**
 * Singleton class to manage the SQLite database connection.
 */
abstract class Database
{
    /** @var Database|null The single instance of the Database class. */
    private static $instance = null;

    /** @var PDO|null The database connection object. */
    protected $conn;

    /**
     * Private constructor for the Singleton pattern.
     */
    protected function __construct()
    {
        $this->openConnection();
    }

    /**
     * Gets the single instance of the Database class.
     * @return Database The singleton instance.
     */
    protected static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * Opens the database connection if it's not already open.
     * @throws Exception If the database connection fails.
     */
    protected function openConnection()
    {
        try {
            $this->conn = new PDO('sqlite:' . $_SERVER['DOCUMENT_ROOT'] . '/ledger.sqlite');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception('Database connection failed: ' . $e->getMessage());
        }
    }

    /**
     * Closes the database connection if it's open.
     */
    protected function closeConnection()
    {
        $this->conn = null;
    }

    /**
     * Prevents the use of the clone operation.
     */
    private function __clone()
    {
    }

    /**
     * Prevents the use of the wakeup operation.
     */
    private function __wakeup()
    {
    }

    /**
     * Destructor to close the database connection when the object is destroyed.
     */
    protected function __destruct()
    {
        $this->closeConnection();
    }
}
