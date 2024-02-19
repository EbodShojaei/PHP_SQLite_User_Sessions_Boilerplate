<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/classes/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/classes/crud/BucketTable.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/classes/crud/UserTable.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/classes/crud/Editable.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/classes/crud/Readable.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/classes/tables/ValidatorTrait.php';
?>
<?php
/**
 * Class to manage transactions in a SQLite database.
 */
class TransactionTable extends Database implements Editable, Readable
{
    use ValidatorTrait;  // Include the ValidatorTrait to validate input.

    /** Constants representing the maximum length of each field. */
    const MAX_DATE_LENGTH = 10;
    const MAX_DESCRIPTION_LENGTH = 100;
    const DECIMAL_PRECISION = 10;
    const DECIMAL_SCALE = 2;

    /**
     * Constructor to initialize the TransactionTable object with a database connection.
     */
    public function __construct()
    {
        parent::__construct();
        $sql = "CREATE TABLE IF NOT EXISTS transactions (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            date VARCHAR(" . self::MAX_DATE_LENGTH . ") NOT NULL,
            description VARCHAR(" . self::MAX_DESCRIPTION_LENGTH . ") NOT NULL,
            amount DECIMAL(" . self::DECIMAL_PRECISION . ", " . self::DECIMAL_SCALE . ") NOT NULL,
            bucket_id INTEGER NOT NULL,
            user_id INTEGER NOT NULL,
            FOREIGN KEY (bucket_id) REFERENCES buckets(id) ON DELETE CASCADE,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )"; // ON DELETE CASCADE to delete transactions when a bucket or user is deleted.

        $this->conn->exec($sql);
    }

    /**
     * Inserts a new transaction into the database.
     *
     * @param array $data The new details for the transaction.
     * @return bool True if insertion is successful, otherwise false.
     */
    public function insert(array $data)
    {
        $this->validate_input($data);
        $date = $data['date'];
        $description = $data['description'];
        $amount = $data['amount'];
        $bucket_id = $data['bucket_id'];

        $stmt = $this->conn->prepare("INSERT INTO transactions (date, description, amount, bucket_id) VALUES (?, ?, ?, ?)");
        $stmt->bindParam(1, $date);
        $stmt->bindParam(2, $description);
        $stmt->bindParam(3, $amount);
        $stmt->bindParam(4, $bucket_id);
        return $stmt->execute();
    }

    /**
     * Updates a transaction's details in the database.
     *
     * @param array $data The new details for the transaction.
     * @return bool True if the update is successful, otherwise false.
     */
    public function update(array $data)
    {
        $this->validate_input($data);
        $id = $data['id'];
        $date = $data['date'];
        $description = $data['description'];
        $amount = $data['amount'];
        $bucket_id = $data['bucket_id'];

        $stmt = $this->conn->prepare("UPDATE transactions SET date = ?, description = ?, amount = ?, bucket_id = ? WHERE id = ?");
        $stmt->bindParam(1, $date);
        $stmt->bindParam(2, $description);
        $stmt->bindParam(3, $amount);
        $stmt->bindParam(4, $bucket_id);
        $stmt->bindParam(5, $id);
        return $stmt->execute();
    }

    /**
     * Removes a transaction from the database.
     *
     * @param int $id The ID of the transaction to remove.
     * @return bool True if the removal is successful, otherwise false.
     */
    public function remove(int $id)
    {
        $this->validate_id($id);
        $stmt = $this->conn->prepare("DELETE FROM transactions WHERE id = ?");
        $stmt->bindParam(1, $id);
        return $stmt->execute();
    }

    /**
     * Retrieves and returns a list of all transactions from the database.
     *
     * @return array The list of transactions.
     */
    public function get_all()
    {
        $stmt = $this->conn->prepare("SELECT * FROM transactions");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Retrieves and returns a transaction by its ID.
     *
     * @param int $id The ID of the transaction to retrieve.
     * @return array The transaction's details.
     */
    public function get_by_id(int $id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM transactions WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * Retrieves and returns a list of transactions by a max number of rows and an offset.
     *
     * @param int|null $max_rows The maximum number of rows to display. Default is null to return all rows.
     * @param int $offset The number of rows to skip before starting to return data.
     * @return array The list of transactions.
     */
    public function get_by_limit(int $max_rows = null, int $offset = 0)
    {
        sanitize_input($max_rows);
        sanitize_input($offset);
        $stmt = $this->conn->prepare("SELECT * FROM transactions LIMIT ? OFFSET ?");
        $stmt->bindParam(1, $max_rows);
        $stmt->bindParam(2, $offset);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Retrieves the total number of transactions in the database.
     *
     * @param string $condition The condition to filter the transactions. Default is an empty string.
     * @return int The total number of transactions.
     */
    public function get_row_count(string $condition = '')
    {
        sanitize_input($condition);
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM transactions" . $condition);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    /**
     * Retrieves and returns a list of transactions by a user ID.
     *
     * @param int $user_id The ID of the user to filter the transactions.
     * @return array The list of transactions.
     */
    public function get_by_user_id(int $user_id)
    {
        sanitize_input($user_id);
        $stmt = $this->conn->prepare("SELECT * FROM transactions WHERE user_id = ?");
        $stmt->bindParam(1, $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Retrieves and returns a list of transactions by a bucket ID.
     *
     * @param int $bucket_id The ID of the bucket to filter the transactions.
     * @return array The list of transactions.
     */
    public function get_by_bucket_id(int $bucket_id)
    {
        sanitize_input($bucket_id);
        $stmt = $this->conn->prepare("SELECT * FROM transactions WHERE bucket_id = ?");
        $stmt->bindParam(1, $bucket_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Retrieves the total sum of transactions by a bucket ID.
     *
     * @param int $bucket_id The ID of the bucket to filter the transactions.
     * @return float The total amount of transactions.
     */
    public function get_total_by_bucket_id(int $bucket_id)
    {
        sanitize_input($bucket_id);
        $stmt = $this->conn->prepare("SELECT SUM(amount) FROM transactions WHERE bucket_id = ?");
        $stmt->bindParam(1, $bucket_id);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    /**
     * Retrieves the total sum of transactions by a date range.
     *
     * @param string $start_date The start date of the date range.
     * @param string $end_date The end date of the date range.
     * @param string $bucket_category The category of the bucket to filter the transactions.
     * @return float The total sum of transactions.
     */
    public function get_total_by_date_range(string $start_date, string $end_date, string $bucket_category = '')
    {
        if ($bucket_category) $this->validate_string($bucket_category, BucketTable::MAX_CATEGORY_LENGTH, "Category");
        $this->validate_date($start_date);
        $this->validate_date($end_date);

        $bucket_stmt = $bucket_category ? "bucket_id IN (SELECT id FROM buckets WHERE category = ?) AND" : "";
        $stmt = $this->conn->prepare("SELECT SUM(amount) FROM transactions WHERE" . $bucket_stmt . " date BETWEEN ? AND ?");
        $stmt->bindParam(1, $start_date);
        $stmt->bindParam(2, $end_date);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    /**
     * Validates the input for an amount.
     *
     * @param string $amount The amount to validate.
     */
    private function validate_amount(string $amount)
    {
        if (!preg_match("/^\d+(\.\d{1,2})?$/", $amount)) {
            throw new InvalidArgumentException("Amount must be a number with up to 2 decimal places.");
        }
    }

    /**
     * Validates the input data for a transaction.
     *
     * @param array $data The transaction's details.
     */
    private function validate_input(array $data)
    {
        if (isset($data['id'])) $this->validate_id($data['id']);
        if (isset($data['date'])) $this->validate_date($data['date']);
        if (isset($data['description'])) $this->validate_string($data['description'], self::MAX_DESCRIPTION_LENGTH, "Description");
        if (isset($data['amount'])) $this->validate_amount($data['amount']);
        if (isset($data['bucket_id'])) $this->validate_id($data['bucket_id']);
        if (isset($data['user_id'])) $this->validate_id($data['user_id']);
    }

    /**
     * Closes the database connection when the object is destroyed.
     */
    public function __destruct()
    {
        parent::__destruct();
    }
}
?>
