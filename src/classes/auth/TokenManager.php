<?php

class TokenManager
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function generateToken($userId)
    {
        $token = bin2hex(random_bytes(32));
        $this->storeToken($userId, $token);
        return $token;
    }

    private function storeToken($userId, $token)
    {
        $sql = "INSERT INTO sessions (user_id, session_token, expires_at) VALUES (:userId, :token, datetime('now', '+3600 seconds'))"; // 3600 seconds = 1 hour
        $this->db->execute($sql, ['userId' => $userId, 'token' => $token]);
    }

    public function validateToken($token)
    {
        $sql = "SELECT id FROM sessions WHERE session_token = :token AND expires_at > datetime('now')";
        $result = $this->db->query($sql, ['token' => $token]);
        return count($result) > 0;
    }

    public function clearToken($token)
    {
        $sql = "DELETE FROM sessions WHERE session_token = :token";
        $this->db->execute($sql, ['token' => $token]);
    }

    public function getUserIdFromToken($token)
    {
        $sql = "SELECT user_id FROM sessions WHERE session_token = :token";
        $result = $this->db->query($sql, ['token' => $token]);
        return $result[0]['user_id'] ?? null;
    }

    public function getUserRoleFromToken($token)
    {
        $userId = $this->getUserIdFromToken($token);
        $sql = "SELECT role FROM users WHERE id = :userId";
        $result = $this->db->query($sql, ['userId' => $userId]);
        return $result[0]['role'] ?? null;
    }
}
