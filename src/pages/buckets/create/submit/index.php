<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/BucketController.php';

    $db = Database::getInstance();
    $tokenManager = new TokenManager($db);
    $currentUserId = $tokenManager->getUserIdFromToken();
    $transaction_name = $_POST['transaction_name'];
    $category = $_POST['category'];
    $bucketController = new BucketController($db);
    $bucket = [
        'user_id' => $currentUserId,
        'transaction_name' => $transaction_name,
        'category' => $category
    ];
    $bucketController->create($bucket);

    Alerts::redirect("Bucket created successfully.", "success", "/buckets");
}