<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/classes/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/classes/crud/Editable.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/classes/crud/Readable.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/classes/tables/ValidatorTrait.php';
?>
<?php
/**
 * Class to manage users in a SQLite database.
 */
class UserTable extends Database implements Editable, Readable
{
    use ValidatorTrait;  // Include the ValidatorTrait to validate input.

    /** Constants representing the maximum length of each field. */
    const MAX_EMAIL_LENGTH = 100;
    const MAX_USERNAME_LENGTH = 50;
    const MAX_PASSWORD_LENGTH = 255;

    /**
     * Constructor to initialize the UserTable object with a database connection.
     */
    public function __construct()
    {
        parent::__construct();
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            email VARCHAR(" . self::MAX_EMAIL_LENGTH . ") NOT NULL,
            username VARCHAR(" . self::MAX_USERNAME_LENGTH . ") NOT NULL,
            password VARCHAR(" . self::MAX_PASSWORD_LENGTH . ") NOT NULL,
            is_approved BOOLEAN NOT NULL DEFAULT 0,
            is_admin BOOLEAN NOT NULL DEFAULT 0
            )";

        $this->conn->exec($sql);
    }

    /**
     * Inserts a new user into the database.
     *
     * @param array $data The new details for the user.
     * @return bool True if insertion is successful, otherwise false.
     */
    public function insert(array $data)
    {
        $this->validate_input($data);
        $email = $data['email'];
        $username = $data['username'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("INSERT INTO users (email, username, password) VALUES (?, ?, ?)");
        $stmt->bindParam(1, $email);
        $stmt->bindParam(2, $username);
        $stmt->bindParam(3, $password);
        return $stmt->execute();
    }

    /**
     * Updates a user's details in the database.
     *
     * @param array $data The new details for the user.
     * @return bool True if the update is successful, otherwise false.
     */
    public function update(array $data)
    {
        $this->validate_input($data);
        $id = $data['id'];
        $email = $data['email'];
        $username = $data['username'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("UPDATE users SET email = ?, username = ?, password = ? WHERE id = ?");
        $stmt->bindParam(1, $email);
        $stmt->bindParam(2, $username);
        $stmt->bindParam(3, $password);
        $stmt->bindParam(4, $id);
        return $stmt->execute();
    }

    /**
     * Removes a user from the database.
     *
     * @param int $id The ID of the user to remove.
     * @return bool True if the removal is successful, otherwise false.
     */
    public function remove(int $id)
    {
        $this->validate_id($id);
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bindParam(1, $id);
        return $stmt->execute();
    }

    /**
     * Retrieves and returns a list of all users from the database.
     *
     * @return array The list of users.
     */
    public function get_all()
    {
        $stmt = $this->conn->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Retrieves and returns a user by their ID.
     *
     * @param int $id The ID of the user to retrieve.
     * @return array The user's details.
     */
    public function get_by_id(int $id)
    {
        $this->validate_id($id);
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * Retrieves and returns a list of users by a max number of rows and an offset.
     *
     * @param int|null $max_rows The maximum number of rows to display. Default is null to return all rows.
     * @param int $offset The number of rows to skip before starting to return data.
     * @return array The list of users.
     */
    public function get_by_limit(int $max_rows = null, int $offset = 0)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users LIMIT ? OFFSET ?");
        $stmt->bindParam(1, $max_rows, PDO::PARAM_INT);
        $stmt->bindParam(2, $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Retrieves the total number of users in the database.
     * @param string $condition The condition to filter the results.
     * @return int The total number of users.
     */
    public function get_row_count(string $condition = '')
    {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM users");
        return $stmt->fetchColumn();
    }

    /**
     * Retrieves a user by their email.
     */
    public function get_by_email(string $email)
    {
        $this->validate_email($email);
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bindParam(1, $email);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * Retrieves a user by their username.
     */
    public function get_by_username(string $username)
    {
        $this->validate_string($username, self::MAX_USERNAME_LENGTH, "Username");
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bindParam(1, $username);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * Validates the email for a user.
     *
     * @param string $email The user's email.
     */
    private function validate_email(string $email)
    {
        $this->validate_string($email, self::MAX_EMAIL_LENGTH, "Email");
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email address.");
        }
    }

    /**
     * Validates the input data for a user.
     *
     * @param array $data The user's details.
     */
    private function validate_input(array $data)
    {
        if (isset($data['id'])) $this->validate_id($data['id']);
        if (isset($data['email'])) $this->validate_email($data['email']);
        if (isset($data['username'])) $this->validate_string($data['username'], self::MAX_USERNAME_LENGTH, "Username");
        if (isset($data['password'])) $this->validate_string($data['password'], self::MAX_PASSWORD_LENGTH, "Password");
    }

    /**
     * Closes the database connection when the object is destroyed.
     */
    protected function __destruct()
    {
        parent::__destruct();
    }
}
?>
