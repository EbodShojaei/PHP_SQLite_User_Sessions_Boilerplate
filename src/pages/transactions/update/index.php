<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/TransactionController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/models/Transaction.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';

$db = Database::getInstance();
$transactionController = new TransactionController($db);
$transactionId = $_GET['id'] ?? null;
$transaction = $transactionController->getTransactionById($transactionId);
if (!$transaction) {
    Alerts::redirect('Transaction not found', 'danger', '/transactions');
    exit;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/_common/_header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/_common/_nav.php';
Alerts::display();
require_once '_update.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/_common/_footer.php';
