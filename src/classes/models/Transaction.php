<?php

class Transaction
{
    public $userId;
    public $date;
    public $name;
    public $expense;
    public $deposit;
    public $balance;
    public $last_updated;

    public function __construct($userId, $date, $name, $expense, $deposit)
    {
        $this->userId = $userId;
        $this->date = $date;
        $this->name = $name;
        $this->expense = $expense;
        $this->deposit = $deposit;
        $this->balance = $deposit - $expense;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getExpense()
    {
        return $this->expense;
    }

    public function getDeposit()
    {
        return $this->deposit;
    }

    public function getBalance()
    {
        return $this->balance;
    }

    public function getTransaction() {
        return [
            'user_id' => $this->userId,
            'date' => $this->date,
            'name' => $this->name,
            'expense' => $this->expense,
            'deposit' => $this->deposit,
            'balance' => $this->balance,
        ];
    }
}
