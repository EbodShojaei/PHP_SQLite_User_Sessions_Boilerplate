<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/BucketController.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';

    $bucketId = $_POST['bucket_id'] ?? '';
    if (empty($bucketId)) {
        Alerts::redirect('Bucket ID is required', 'danger', '/buckets');
        exit;
    }

    // Extract other POST variables
    $transaction_name = $_POST['transaction_name'] ?? null;
    $category = $_POST['category'] ?? null;

    $db = Database::getInstance();
    $bucketController = new BucketController($db);
    $bucketData = [
        'bucket_id' => $bucketId,
        'transaction_name' => $transaction_name,
        'category' => $category,
    ];

    try {
        $bucketController->update($bucketData);
        Alerts::redirect("Bucket updated successfully.", "success", "/buckets");
        exit;
    } catch (Exception $e) {
        Alerts::redirect($e->getMessage(), "danger", "/buckets/update/" . $bucketId);
        exit;
    }
}
