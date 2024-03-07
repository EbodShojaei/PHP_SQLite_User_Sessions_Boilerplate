<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';

    $db = Database::getInstance();
    $transaction_name = $_POST['transaction_name'];
    $category = $_POST['category'];

    $sql = "INSERT INTO buckets (transaction_name, category) VALUES (?, ?)";
    $stmt = $db->execute($sql, [$transaction_name, $category]);
    
    Alerts::redirect("Bucket created successfully.", "success", "/buckets");
}