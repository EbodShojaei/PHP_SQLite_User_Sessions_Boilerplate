<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/TransactionController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $transactionId = $_POST['trans_id'] ?? '';
    if (empty($transactionId)) {
        Alerts::redirect('Transaction ID is required', 'danger', '/transactions');
        exit;
    }

    // Extract other POST variables
    $name = $_POST['name'] ?? null;
    $expense = $_POST['expense'] ?? null;
    $deposit = $_POST['deposit'] ?? null;
    $date = $_POST['date'] ?? null;

    $db = Database::getInstance();
    $transactionController = new TransactionController($db);
    $transactionData = [
        'trans_id' => $transactionId,
        'name' => $name,
        'expense' => $expense,
        'deposit' => $deposit,
        'date' => $date
    ];

    try {
        $transactionController->update($transactionData);
        Alerts::redirect("Transaction updated successfully.", "success", "/transactions");
    } catch (Exception $e) {
        Alerts::redirect($e->getMessage(), "danger", "/transactions/update/");
    }
}
