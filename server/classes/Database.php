<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/sanitize_input.php';
?>

<?php

/**
 * Singleton class to manage the SQLite database.
 * The database contains tables for accounts, sessions, transactions, and buckets.
 */
class Database
{
    /** @var Database|null The single instance of the Database class. */
    private static $instance = null;

    /** @var PDO|null The database connection object. */
    private static $conn;

    /**
     * Private constructor for the Singleton pattern.
     */
    private function __construct()
    {
        try {
            self::open_db();
            self::init_tables();
            self::close_db();
        } catch (Exception $e) {
            exit('Database connection failed: ' . $e->getMessage());
        }
    }

    /**
     * Private destructor for the Singleton pattern.
     */
    private function __destruct()
    {
        self::close_db();
    }

    /**
     * Gets the single instance of the Database class.
     *
     * @return Database The singleton instance.
     */
    public static function get_instance()
    {
        if (self::$instance === null) self::$instance = new Database();
        return self::$instance;
    }

    /**
     * Opens the database connection if it's not already open.
     *
     * @return void
     */
    private static function open_db()
    {
        try {
            if (self::$conn === null) {
                self::$conn = new PDO('sqlite:' . $_SERVER['DOCUMENT_ROOT'] . '/ledger.sqlite');
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
        } catch (PDOException $e) {
            // Handle connection error (e.g., log error)
            throw new Exception('Database connection failed: ' . $e->getMessage());
        }
    }

    /**
     * Closes the database connection if it's open.
     *
     * @return void
     */
    private static function close_db()
    {
        if (self::$conn !== null) self::$conn = null;
    }

    /**
     * Gets the database connection object.
     *
     * @return PDO The database connection object.
     */
    public function get_connection()
    {
        self::open_db();
        return self::$conn;
    }

    /**
     * Executes a query on the database.
     *
     * @param string $sql The SQL query to execute.
     * @param array $params The parameters to bind to the query.
     * @return PDOStatement The result of the query.
     */
    public static function execute_query($sql, $params = [])
    {
        try {
            // Sanitize the input
            foreach ($params as $key => $value) $params[$key] = sanitize_input($value);
            self::open_db();
            $stmt = self::$conn->prepare($sql);
            $stmt->execute($params);
            $query_type = self::check_query_type($sql, $stmt);
            self::close_db();
            return $query_type;
        } catch (PDOException $e) {
            throw new Exception('Query failed: ' . $e->getMessage());
        }
    }

    /**
     * Checks the type of query and returns the result.
     *
     * @param string $sql The SQL query to execute.
     * @param PDOStatement $stmt The result of the query.
     * @return mixed The result of the query.
     */
    private static function check_query_type($sql, $stmt)
    {
        $query_type = explode(' ', $sql)[0];
        switch ($query_type) {
            case 'SELECT':
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            case 'INSERT':
                return self::$conn->lastInsertId();
            case 'UPDATE':
                return $stmt->rowCount();
            case 'DELETE':
                return $stmt->rowCount();
            case 'CREATE':
                return $stmt->rowCount();
            default:
                throw new Exception('Invalid query type');
        }
    }

    /**
     * Creates the tables in the database if they do not exist.
     */
    private static function init_tables()
    {
        try {
            self::init_accounts_table();
            self::init_sessions_table();
            self::init_transactions_table();
            self::init_buckets_table();
        } catch (PDOException $e) {
            // Handle table creation error (e.g., log error)
            throw new Exception('Table creation failed: ' . $e->getMessage());
        }
    }

    /**
     * Creates the accounts table in the database.
     *
     * @return void
     */
    private static function init_accounts_table()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS accounts (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            email TEXT NOT NULL UNIQUE,
            username TEXT NOT NULL UNIQUE,
            password TEXT NOT NULL
        )';
        self::$conn->exec($sql);
    }

    /**
     * Creates the sessions table in the database.
     * The session token is used to authorize the user's access to the application.
     * The token is deleted when the user logs out or the session expires.
     *
     * @return void
     */
    private static function init_sessions_table()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS sessions (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            token TEXT NOT NULL,
            expiry DATETIME NOT NULL,
            FOREIGN KEY (user_id) REFERENCES accounts(id)
        )';
        self::$conn->exec($sql);
    }

    /**
     * Creates the transactions table in the database.
     * The transactions table records the user's financial transactions.
     *
     * @return void
     */
    private static function init_transactions_table()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS transactions (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            amount REAL NOT NULL,
            date DATETIME NOT NULL,
            description TEXT NOT NULL,
            FOREIGN KEY (user_id) REFERENCES accounts(id)
        )';
        self::$conn->exec($sql);
    }

    /**
     * Creates the buckets table in the database.
     * The buckets table records the user's financial goals.
     *
     * @return void
     */
    private static function init_buckets_table()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS buckets (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            amount REAL NOT NULL,
            description TEXT NOT NULL,
            FOREIGN KEY (user_id) REFERENCES accounts(id)
        )';
        self::$conn->exec($sql);
    }
}
?>
