<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/CRUD.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/auth/TokenManager.php';

class BucketController implements CRUD
{
    private $db;
    private $tokenManager;
    private $userId;

    public function __construct(Database $db)
    {
        $this->db = $db;
        $this->tokenManager = new TokenManager($db);
        $this->userId = $this->tokenManager->getUserIdFromToken() ?? Alerts::redirect("You must login first.", "danger", "/login");
    }

    public function create($bucket)
    {
        $sql = "INSERT INTO buckets (user_id, transaction_name, category) VALUES (:user_id, :transaction_name, :category)";
        $params = [
            'user_id' => $this->userId,
            'transaction_name' => $bucket['transaction_name'],
            'category' => $bucket['category'],
        ];
        return $this->db->execute($sql, $params);
    }

    public function read($bucket_id)
    {
        $sql = "SELECT * FROM buckets WHERE bucket_id = :bucket_id AND user_id = :user_id";
        $params = [
            'bucket_id' => $bucket_id,
            'user_id' => $this->userId,
        ];
        return $this->db->query($sql, $params);
    }

    public function update($bucket)
    {
        $existingBucket = $this->getBucketById($bucket['bucket_id']);
        // if (!$existingBucket) {
        //     Alerts::redirect("Bucket not found.", "danger", "/buckets");
        // }

        $sql = "UPDATE buckets SET transaction_name = :transaction_name, category = :category WHERE bucket_id = :bucket_id AND user_id = :user_id";
        $params = [
            'bucket_id' => $bucket['bucket_id'],
            'user_id' => $this->userId,
            'transaction_name' => $bucket['transaction_name'],
            'category' => $bucket['category'],
        ];

        if (!$this->db->execute($sql, $params)) {
            Alerts::redirect("Error updating bucket.", "danger", "/buckets/update/" . $bucket['bucket_id']);
        }
    }

    public function delete($bucket_id)
    {
        $sql = "DELETE FROM buckets WHERE bucket_id = :bucket_id AND user_id = :user_id";
        $params = [
            'bucket_id' => $bucket_id,
            'user_id' => $this->userId,
        ];
        return $this->db->execute($sql, $params);
    }

    public function getBucketById($bucketId)
    {
        $sql = "SELECT * FROM buckets WHERE bucket_id = :bucket_id AND user_id = :user_id";
        $params = ['bucket_id' => $bucketId, 'user_id' => $this->userId];
        $result = $this->db->query($sql, $params);
        return $result[0] ?? null;
    }

    public function getAllBuckets()
    {
        $sql = "SELECT * FROM buckets WHERE user_id = :user_id";
        $params = ['user_id' => $this->userId];
        return $this->db->query($sql, $params) ?? [];
    }
}
