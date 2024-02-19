<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/classes/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/classes/crud/Editable.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/classes/crud/Readable.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/classes/tables/ValidatorTrait.php';
?>
<?php
/**
 * Class to manage buckets (expense categories) in a SQLite database.
 */
class BucketTable extends Database implements Editable, Readable
{
    use ValidatorTrait;  // Include the ValidatorTrait to validate input.

    /** Constants representing the maximum length of each field. */
    const MAX_CATEGORY_LENGTH = 50;
    const MAX_NAME_LENGTH = 50;

    /**
     * Constructor to initialize the BucketTable object with a database connection.
     */
    public function __construct()
    {
        parent::__construct();
        $sql = "CREATE TABLE IF NOT EXISTS buckets (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            category VARCHAR(" . self::MAX_CATEGORY_LENGTH . ") NOT NULL,
            name VARCHAR(" . self::MAX_NAME_LENGTH . ") NOT NULL
            )";

        $this->conn->exec($sql);
    }

    /**
     * Inserts a new bucket into the database.
     *
     * @param array $data The new details for the bucket.
     * @return bool True if insertion is successful, otherwise false.
     */
    public function insert(array $data)
    {
        $this->validate_input($data);
        $category = $data['category'];
        $name = $data['name'];

        $stmt = $this->conn->prepare("INSERT INTO buckets (category, name) VALUES (?, ?)");
        $stmt->bindParam(1, $category);
        $stmt->bindParam(2, $name);
        return $stmt->execute();
    }

    /**
     * Updates a bucket's details in the database.
     *
     * @param array $data The new details for the bucket.
     * @return bool True if update is successful, otherwise false.
     */
    public function update(array $data)
    {
        $this->validate_input($data);
        $id = $data['id'];
        $category = $data['category'];
        $name = $data['name'];

        $stmt = $this->conn->prepare("UPDATE buckets SET category = ?, name = ? WHERE id = ?");
        $stmt->bindParam(1, $category);
        $stmt->bindParam(2, $name);
        $stmt->bindParam(3, $id);
        return $stmt->execute();
    }

    /**
     * Removes a bucket from the database.
     *
     * @param int $id The ID of the bucket to remove.
     * @return bool True if removal is successful, otherwise false.
     */
    public function remove(int $id)
    {
        $stmt = $this->conn->prepare("DELETE FROM buckets WHERE id = ?");
        $stmt->bindParam(1, $id);
        return $stmt->execute();
    }

    /**
     * Retrieves all buckets from the database.
     *
     * @return array An array of all buckets in the database.
     */
    public function get_all()
    {
        $stmt = $this->conn->prepare("SELECT * FROM buckets");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Retrieves a bucket by its ID.
     *
     * @param int $id The ID of the bucket to retrieve.
     * @return array The bucket's details.
     */
    public function get_by_id(int $id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM buckets WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * Retrieves a bucket by its category.
     *
     * @param string $category The category of the bucket to retrieve.
     * @return array The bucket's details.
     */
    public function get_by_category(string $category)
    {
        $stmt = $this->conn->prepare("SELECT * FROM buckets WHERE category = ?");
        $stmt->bindParam(1, $category);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * Retrieves a bucket by its name.
     *
     * @param string $name The name of the bucket to retrieve.
     * @return array The bucket's details.
     */
    public function get_by_name(string $name)
    {
        $stmt = $this->conn->prepare("SELECT * FROM buckets WHERE name = ?");
        $stmt->bindParam(1, $name);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * Retrieves a list of buckets by a max number of rows and an offset.
     *
     * @param int|null $max_rows The maximum number of rows to display. Default is null to return all rows.
     * @param int $offset The number of rows to skip before starting to return data.
     */
    public function get_by_limit(int $max_rows = null, int $offset = 0)
    {
        $stmt = $this->conn->prepare("SELECT * FROM buckets LIMIT ? OFFSET ?");
        $stmt->bindParam(1, $max_rows, PDO::PARAM_INT);
        $stmt->bindParam(2, $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Retrieves the total number of buckets in the database.
     *
     * @return int The total number of buckets.
     */
    public function get_row_count()
    {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM buckets");
        return $stmt->fetchColumn();
    }

    /**
     * Validates the input data for a bucket.
     *
     * @param array $data The data to validate.
     */
    private function validate_input(array $data)
    {
        if (isset($data['id'])) $this->validate_id($data['id']);
        if (isset($data['category'])) $this->validate_string($data['category'], self::MAX_CATEGORY_LENGTH, "Category");
        if (isset($data['name'])) $this->validate_string($data['name'], self::MAX_NAME_LENGTH, "Name");
    }
}
?>
