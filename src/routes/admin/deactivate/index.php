<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';

$db = Database::getInstance();

// Check for POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['deactivate'])) {
        $userId = $_POST['deactivate'];
        // Validate the user ID and perform deactivation
        $db->query("UPDATE users SET status = 'inactive' WHERE id = ?", [$userId]);
        Alerts::redirect("User deactivated.", "success", "/admin");
    } else {
        Alerts::redirect("Invalid request.", "danger", "/admin");
    }
}
