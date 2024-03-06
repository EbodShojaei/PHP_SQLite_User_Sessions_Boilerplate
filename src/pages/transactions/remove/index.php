<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/TransactionController.php';

    $db = Database::getInstance();
    $transactionController = new TransactionController($db);
    $transactionId = intval($_POST['id']);

    try {
        if ($transactionController->delete($transactionId)) {
            Alerts::redirect("Transaction removed successfully.", "success", "/transactions");
        } else {
            Alerts::redirect("Failed to remove transaction.", "danger", "/transactions");
        }
    } catch (Exception $e) {
        Alerts::redirect($e->getMessage(), "danger", "/transactions");
    }
}
