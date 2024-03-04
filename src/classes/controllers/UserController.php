<?php

class UserController
{
    private $db;
    private $tokenManager;

    public function __construct(Database $db)
    {
        $this->db = $db;
        $this->tokenManager = new TokenManager($db);
    }

    public function login($email, $password)
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $user = $this->db->query($sql, [$email]);

        if (count($user) === 1 && password_verify($password, $user[0]['password'])) {
            $userId = $user[0]['id'];
            $token = $this->tokenManager->generateToken($userId);
            Cookie::set('auth_token', $token, 3600); // 3600 seconds = 1 hour
            return true;
        }
        return false;
    }

    public function logout($userId)
    {
        $this->tokenManager->clearToken($userId);
        Cookie::delete('auth_token');
    }
}
