<?php

class Transaction
{
    public $userId;
    public $date;
    public $name;
    public $expense;
    public $deposit;
    public $balance;

    public function __construct($userId, $date, $name, $expense, $deposit)
    {
        $this->userId = $userId;
        $this->date = $date;
        $this->name = $name;
        $this->expense = $expense;
        $this->deposit = $deposit;
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
}
