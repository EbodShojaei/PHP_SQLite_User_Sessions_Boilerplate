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

    public function getTransactions()
    {
        $sql = "SELECT t.*, b.category
                FROM transactions t
                LEFT JOIN buckets b ON t.name LIKE '%' || b.transaction_name || '%'
                WHERE t.user_id = :user_id";
        $params = ['user_id' => $this->userId];
        return $this->db->query($sql, $params);
    }

    public function getLatestBalance()
    {
        $sql = "SELECT overall_balance 
                FROM transactions 
                WHERE user_id = :user_id 
                ORDER BY transaction_date DESC, transaction_id DESC LIMIT 1";
        $params = ['user_id' => $this->userId];
        $result = $this->db->query($sql, $params);
        return $result ? $result[0]['overall_balance'] : 0;
    }

    public function getTransactionById($id)
    {
        $sql = "SELECT * 
                FROM transactions 
                WHERE transaction_id = :id AND user_id = :user_id";
        $params = ['id' => $id, 'user_id' => $this->userId];
        $result = $this->db->query($sql, $params);
        return $result ? $result[0] : null;
    }

    public function getLastBalanceBefore($date)
    {
        $sql = "SELECT overall_balance 
                FROM transactions 
                WHERE transaction_date < :date AND user_id = :user_id 
                ORDER BY transaction_date DESC LIMIT 1";
        $params = ['date' => $date, 'user_id' => $this->userId];
        $result = $this->db->query($sql, $params);
        return $result ? $result[0]['overall_balance'] : 0;
    }
}
