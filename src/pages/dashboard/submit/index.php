<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/DashboardController.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $year = $_POST['year'] ?? date('Y'); // Fallback to the current year if not set
    // Store the selected year in the session or another preferred method
    $_SESSION['dashboard_year'] = $year;
}

// Redirect back to the dashboard page
header("Location: /dashboard");
exit;
