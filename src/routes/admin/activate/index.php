<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';

$db = Database::getInstance();

// Check for POST request to activate
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    // Perform activation
    $db->query("UPDATE users SET status = 'active' WHERE id = ?", [$userId]);
    Alerts::redirect("User activated.", "success", "/admin");
} else {
    Alerts::redirect("Invalid request.", "danger", "/admin");
}
