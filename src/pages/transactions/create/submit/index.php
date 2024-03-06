<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/auth/TokenManager.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/TransactionController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Sanitizer.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Validator.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sql/constants/transactions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Sanitize then validate inputs
        $date = Sanitizer::sanitizeString($_POST['date'] ?? '');
        $name = Sanitizer::sanitizeString($_POST['name'] ?? '');
        $expense = floatval(Sanitizer::sanitizeString($_POST['expense'] ?? ''));
        $deposit = floatval(Sanitizer::sanitizeString($_POST['deposit'] ?? ''));
        Validator::validateDate($date, "/transactions/create");
        Validator::validateInput($name, TRANS_NAME_MIN_LEN, TRANS_NAME_MAX_LEN, "/transactions/create");
        Validator::validateFloat($expense, "/transactions/create");
        Validator::validateInput($deposit, "/transactions/create");

        // Create transaction
        $db = Database::getInstance();
        $transactionController = new TransactionController($db);
        $tokenManager = new TokenManager($db);
        $currentUserId = $tokenManager->getUserIdFromToken();

        if ($transactionController->create(new Transaction(userId: $currentUserId, date: $date, name: $name, expense: $expense, deposit: $deposit))) {
            Alerts::redirect("Transaction created successfully.", "success", "/transactions");
            exit();
        } else {
            Alerts::redirect("Failed to create transaction.", "danger", "/transactions/create");
        }
    } catch (Exception $e) {
        Alerts::redirect($e->getMessage(), "danger", "/transactions/create");
    }
}
