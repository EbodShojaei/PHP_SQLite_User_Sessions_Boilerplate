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
        $hashedToken = $this->hashToken($token);
        $this->storeToken($userId, $hashedToken);
        return $token;
    }

    private function hashToken($token)
    {
        return hash('sha256', $token);
    }

    private function storeToken($userId, $hashedToken)
    {
        $sql = "UPDATE users SET token = ? WHERE id = ?";
        $this->db->execute($sql, [$hashedToken, $userId]);
    }

    public function validateToken($token, $userId)
    {
        $hashedToken = $this->hashToken($token);
        $sql = "SELECT id FROM users WHERE token = ? AND id = ?";
        $result = $this->db->query($sql, [$hashedToken, $userId]);
        return count($result) > 0;
    }

    public function clearToken($userId)
    {
        $sql = "UPDATE users SET token = NULL WHERE id = ?";
        $this->db->execute($sql, [$userId]);
    }

    public function getToken($userId)
    {
        $sql = "SELECT token FROM users WHERE id = ?";
        $result = $this->db->query($sql, [$userId]);
        return $result[0]['token'];
    }

    public function getUserIdFromToken($token)
    {
        $hashedToken = $this->hashToken($token);
        $sql = "SELECT id FROM users WHERE token = ?";
        $result = $this->db->query($sql, [$hashedToken]);
        return $result[0]['id'];
    }

    public function getUserRoleFromToken($token)
    {
        $hashedToken = $this->hashToken($token);
        $sql = "SELECT role FROM users WHERE token = ?";
        $result = $this->db->query($sql, [$hashedToken]);
        return $result[0]['role'];
    }
}
