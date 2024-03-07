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
        $this->userId = $this->tokenManager->getUserIdFromToken() ?? Alerts::redirect("You must login first.", "danger", "/login");
    }

    public function create($transaction)
    {
        $sql = "INSERT INTO transactions (user_id, name, expense, deposit, balance) VALUES (:user_id, :name, :expense, :deposit, :balance)";
        $params = [
            'user_id' => $this->userId,
            'name' => $transaction->getName(),
            'expense' => $transaction->getExpense(),
            'deposit' => $transaction->getDeposit(),
            'balance' => $transaction->getBalance(),
        ];
        return $this->db->execute($sql, $params);
    }

    public function read($trans_id)
    {
        $sql = "SELECT * FROM transactions WHERE trans_id = :trans_id";
        $params = ['trans_id' => $trans_id];
        return $this->db->query($sql, $params);
    }

    public function update($transaction)
    {
        // Check if transaction exists
        $existingTransaction = $this->getTransactionById($transaction['id']);
        if (!$existingTransaction) {
            Alerts::redirect("Transaction not found.", "danger", "/transactions");
        }    

        if (empty($transaction['expense']) && empty($transaction['deposit'])) {
            Alerts::redirect("Either expense or deposit must be provided.", "danger", "/transactions/update/" . $transaction['trans_id']);
        }

        $expense = empty($transaction['expense']) ? 0 : floatval($transaction['expense']);
        $deposit = empty($transaction['deposit']) ? 0 : floatval($transaction['deposit']);

        if ($expense > 0 && $deposit > 0) {
            Alerts::redirect("Only either the expense or deposit should be entered, not both.", "danger", "/transactions/update/" . $transaction['trans_id']);
        }

        $transaction = $transaction->getTransaction();
        $sql = "UPDATE transactions SET name = :name, expense = :expense, deposit = :deposit, balance = :balance, last_updated = :last_updated WHERE trans_id = :trans_id AND user_id = :user_id";
        $params = [
            'trans_id' => $transaction['trans_id'],
            'user_id' => $this->userId,
            'name' => $transaction['name'],
            'expense' => $transaction['expense'],
            'deposit' => $transaction['deposit'],
            'balance' => $transaction['balance'],
            'last_updated' => $transaction['last_updated'],
        ];

        if (!$this->db->execute($sql, $params)) {
            Alerts::redirect("Error updating transaction.", "danger", "/transactions/update/" . $transaction['trans_id']);
        }

        $this->updateBalancesAfterDate($transaction['date']);
    }

    public function delete($trans_id)
    {
        $sql = "DELETE FROM transactions WHERE trans_id = :trans_id AND user_id = :user_id";
        $params = [
            'trans_id' => $trans_id,
            'user_id' => $this->userId,
        ];
        return $this->db->execute($sql, $params);
    }

    public function getTransactions()
    {
        $sql = "SELECT t.*, b.category FROM transactions t LEFT JOIN buckets b ON t.name LIKE '%' || b.transaction_name || '%' WHERE t.user_id = :user_id";
        $params = ['user_id' => $this->userId];
        return $this->db->query($sql, $params);
    }

    public function getTransactionById($trans_id)
    {
        $sql = "SELECT * FROM transactions WHERE trans_id = :trans_id AND user_id = :user_id";
        $params = ['trans_id' => $trans_id, 'user_id' => $this->userId];
        return $this->db->query($sql, $params)[0] ?? null;
    }

    private function updateBalancesAfterDate($date)
    {
        $balance = $this->getLastBalanceBefore($date);

        $sql = "SELECT * FROM transactions WHERE date >= :date AND user_id = :user_id ORDER BY date ASC";
        $params = ['date' => $date, 'user_id' => $this->userId];
        $transactions = $this->db->query($sql, $params);

        foreach ($transactions as $transaction) {
            $balance += $transaction['deposit'] - $transaction['expense'];
            $this->updateBalanceForTransaction($transaction['trans_id'], $balance);
        }
    }

    private function updateBalanceForTransaction($trans_id, $balance)
    {
        $sql = "UPDATE transactions SET balance = :balance WHERE trans_id = :trans_id AND user_id = :user_id";
        $params = ['balance' => $balance, 'trans_id' => $trans_id, 'user_id' => $this->userId];
        $this->db->execute($sql, $params);
    }

    private function getLastBalanceBefore($date)
    {
        $sql = "SELECT balance FROM transactions WHERE date < :date AND user_id = :user_id ORDER BY date DESC LIMIT 1";
        $params = ['date' => $date, 'user_id' => $this->userId];
        $result = $this->db->query($sql, $params);
        return $result[0]['balance'] ?? 0;
    }
}
