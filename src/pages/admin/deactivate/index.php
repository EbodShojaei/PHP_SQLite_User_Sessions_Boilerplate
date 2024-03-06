<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';

$db = Database::getInstance();

// Check for POST request to deactivate
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    // Perform deactivation
    $db->query("UPDATE users SET status = 'inactive' WHERE id = ?", [$userId]);
    Alerts::redirect("User deactivated.", "success", "/admin");
} else {
    Alerts::redirect("Invalid request.", "danger", "/admin");
}
?>
