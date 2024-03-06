<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/CRUD.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/models/Transaction.php';

class TransactionController implements CRUD
{
    private $db;
    private $tokenManager;
    private $userId;

    public function __construct(Database $db)
    {
        $this->db = $db;
        $this->tokenManager = new TokenManager($db);
        $this->userId = $this->tokenManager->getUserIdFromToken() ?? Alerts::redirect("You must login first.", "danger", "/");
    }

    public function create($transaction)
    {
        $sql = "INSERT INTO transactions (user_id, amount, description, date) VALUES (:user_id, :amount, :description, :date)";
        $params = [
            'user_id' => $this->userId,
            'amount' => $transaction->getAmount(),
            'description' => $transaction->getDescription(),
            'date' => $transaction->getDate(),
        ];
        return $this->db->execute($sql, $params);
    }

    public function read($transaction_id)
    {
        $sql = "SELECT * FROM transactions WHERE id = :id";
        $params = ['id' => $transaction_id];
        return $this->db->query($sql, $params);
    }

    public function update($transaction)
    {
        $sql = "UPDATE transactions SET amount = :amount, description = :description, date = :date WHERE id = :id";
        $params = [
            'amount' => $transaction->getAmount(),
            'description' => $transaction->getDescription(),
            'date' => $transaction->getDate(),
            'id' => $transaction->getId(),
        ];
        return $this->db->execute($sql, $params);
    }

    public function delete($transaction_id)
    {
        $sql = "DELETE FROM transactions WHERE id = :id";
        $params = ['id' => $transaction_id];
        return $this->db->execute($sql, $params);
    }

    public function readAll()
    {
        $sql = "SELECT * FROM transactions WHERE user_id = :user_id";
        $params = ['user_id' => $this->userId];
        return $this->db->query($sql, $params);
    }

    public function readAllByBucket($bucket_id)
    {
        $sql = "SELECT * FROM transactions WHERE user_id = :user_id AND bucket_id = :bucket_id";
        $params = ['user_id' => $this->userId, 'bucket_id' => $bucket_id];
        return $this->db->query($sql, $params);
    }
}
