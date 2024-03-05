<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';

$db = Database::getInstance();

// Check for POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['activate'])) {
        $userId = $_POST['activate'];
        // Validate the user ID and perform activation
        $db->query("UPDATE users SET status = 'active' WHERE id = ?", [$userId]);
        Alerts::redirect("User activated.", "success", "/admin");
    } else {
        Alerts::redirect("Invalid request.", "danger", "/admin");
    }
}
