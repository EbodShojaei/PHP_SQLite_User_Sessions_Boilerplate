<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/models/User.php';

class UserController
{
    private $db;
    private $tokenManager;

    public function __construct(Database $db)
    {
        $this->db = $db;
        $this->tokenManager = new TokenManager($db);
    }

    public function register($email, $nickname, $password)
    {
        // Check if the email already exists in the database
        $sql = "SELECT COUNT(*) FROM users WHERE email = ?";
        $existingUser = $this->db->query($sql, [$email]);
        if ($existingUser[0]['COUNT(*)'] > 0) throw new Exception("Email already in use.");

        // Hash the password for secure storage
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user into the database
        $sql = "INSERT INTO users (email, nickname, password) VALUES (:email, :nickname, :password)";
        $params = ['email' => $email, 'nickname' => $nickname, 'password' => $hashedPassword];
        return $this->db->execute($sql, $params);
    }

    public function login($email, $password)
    {
        // Find the user with the given email
        $sql = "SELECT * FROM users WHERE email = :email";
        $user = $this->db->query($sql, ['email' => $email]);
        $userStatus = $user[0]['status'];

        // Check if the user exists and is active
        if (count($user) === 0) throw new Exception("User not found.");
        if ($userStatus !== 'active') throw new Exception("User is not active.");

        // Verify the password
        if (count($user) === 1 && password_verify($password, $user[0]['password'])) {
            $userId = $user[0]['id'];
            $token = $this->tokenManager->generateToken($userId);
            // Assuming Cookie::set handles token storage in cookies
            Cookie::set('auth_token', $token, 3600); // 3600 seconds = 1 hour
            $_SESSION['user_role'] = $user[0]['role'];
            return true;
        }
        return false;
    }

    public function logout($token, $userId=null)
    {
        if ($userId === null) {
            $userId = $this->tokenManager->getUserIdFromToken($token);
        }
        $this->tokenManager->clearToken($userId);
        Cookie::delete('auth_token');
    }

    public function getUser($token, $userId = null)
    {
        if ($userId !== null) {
            $sql = "SELECT * FROM users WHERE id = ?";
            $data = $this->db->query($sql, [$userId]);
            $user = new User($data[0]['id'], $data[0]['email'], $data[0]['nickname']);
            return $user;
        } else {
            return $this->getUserFromToken($token);
        }
    }

    private function getUserFromToken($token)
    {
        $userId = $this->tokenManager->getUserIdFromToken($token);
        if ($userId === null) {
            return null;
        }

        $sql = "SELECT * FROM users WHERE id = ?";
        $data = $this->db->query($sql, [$userId]);
        $user = new User($data[0]['id'], $data[0]['email'], $data[0]['nickname'], $data[0]['role'], $data[0]['status']);
        return $user;
    }
}
