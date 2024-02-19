<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/classes/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/classes/crud/Editable.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/classes/crud/Readable.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/server/classes/tables/ValidatorTrait.php';
?>
<?php
/**
 * Class to manage sessions in a SQLite database.
 */
class SessionTable extends Database implements Editable, Readable
{
    use ValidatorTrait;  // Include the ValidatorTrait to validate input.

    /** Constants representing the maximum length of each field. */
    const MAX_USER_ID_LENGTH = 10;
    const MAX_TOKEN_LENGTH = 255;

    /**
     * Constructor to initialize the SessionTable object with a database connection.
     */
    public function __construct()
    {
        parent::__construct();
        $sql = "CREATE TABLE IF NOT EXISTS sessions (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            token VARCHAR(" . self::MAX_TOKEN_LENGTH . ") NOT NULL,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            )";  // ON DELETE CASCADE to delete not-yet-expired sessions when a user is deleted.

        $this->conn->exec($sql);
    }

    /**
     * Inserts a new session into the database.
     *
     * @param array $data The new details for the session.
     * @return bool True if insertion is successful, otherwise false.
     */
    public function insert(array $data)
    {
        $this->validate_input($data);
        $user_id = $data['user_id'];
        $token = $data['token'];

        $stmt = $this->conn->prepare("INSERT INTO sessions (user_id, token) VALUES (?, ?)");
        $stmt->bindParam(1, $user_id);
        $stmt->bindParam(2, $token);
        return $stmt->execute();
    }

    /**
     * Updates a session's details in the database.
     *
     * @param array $data The new details for the session.
     * @return bool True if update is successful, otherwise false.
     */
    public function update(array $data)
    {
        $this->validate_input($data);
        $id = $data['id'];
        $user_id = $data['user_id'];
        $token = $data['token'];

        $stmt = $this->conn->prepare("UPDATE sessions SET user_id = ?, token = ? WHERE id = ?");
        $stmt->bindParam(1, $user_id);
        $stmt->bindParam(2, $token);
        $stmt->bindParam(3, $id);
        return $stmt->execute();
    }

    /**
     * Removes a session from the database.
     *
     * @param int $id The ID of the session to remove.
     * @return bool True if removal is successful, otherwise false.
     */
    public function remove(int $id)
    {
        $this->validate_id($id);
        $stmt = $this->conn->prepare("DELETE FROM sessions WHERE id = ?");
        $stmt->bindParam(1, $id);
        return $stmt->execute();
    }

    /**
     * Get a session by its ID.
     *
     * @param int $id The ID of the session to retrieve.
     * @return array The session's details.
     */
    public function get_by_id(int $id)
    {
        $this->validate_id($id);
        $stmt = $this->conn->prepare("SELECT * FROM sessions WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get a session by its user ID.
     *
     * @param int $user_id The ID of the user to retrieve the session for.
     * @return array The session's details.
     */
    public function get_by_user_id(int $user_id)
    {
        $this->validate_id($user_id);
        $stmt = $this->conn->prepare("SELECT * FROM sessions WHERE user_id = ?");
        $stmt->bindParam(1, $user_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get sessions by a max number of rows and an offset.
     *
     * @param int|null $max_rows The maximum number of rows to display. Default is null to return all rows.
     * @param int $offset The number of rows to skip before starting to return data.
     * @return array The list of sessions.
     */
    public function get_by_limit(int $max_rows = null, int $offset = 0)
    {
        sanitize_input($max_rows);
        sanitize_input($offset);
        $stmt = $this->conn->prepare("SELECT * FROM sessions LIMIT ? OFFSET ?");
        $stmt->bindParam(1, $max_rows, PDO::PARAM_INT);
        $stmt->bindParam(2, $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all sessions from the database.
     *
     * @return array The list of sessions.
     */
    public function get_all()
    {
        $stmt = $this->conn->prepare("SELECT * FROM sessions");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get the total number of sessions in the database.
     *
     * @return int The total number of sessions.
     */
    public function get_row_count()
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM sessions");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    /**
     * Validates the input data.
     *
     * @param array $data The data to validate.
     */
    private function validate_input(array $data)
    {
        if (isset($data['user_id'])) $this->validate_id($data['user_id']);
        if (isset($data['token'])) $this->validate_string($data['token'], self::MAX_TOKEN_LENGTH, "Token");
    }
}
?>
