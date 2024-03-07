<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/auth/TokenManager.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/TransactionController.php';
    // get all transactions
    $db = Database::getInstance();
    $transactionController = new TransactionController($db);
    $transactions = $transactionController->getTransactions();

    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/_common/_header.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/_common/_nav.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/models/Transaction.php';
    Alerts::display();
    require_once '_transactions.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/_common/_footer.php';
}