<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bucket_id'])) {
    $bucketId = $_POST['bucket_id'] ?? Alerts::redirect('Bucket ID is required', 'danger', '/buckets');
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/BucketController.php';

    try {
        $db = Database::getInstance();
        $bucketController = new BucketController($db);
        if ($bucketController->delete($bucketId)) {
            Alerts::redirect("Bucket removed successfully.", "success", "/buckets");
        } else {
            Alerts::redirect("Failed to remove bucket.", "danger", "/buckets");
        }
    } catch (Exception $e) {
        Alerts::redirect($e->getMessage(), "danger", "/buckets");
    }
} else {
    Alerts::redirect("Bucket ID is required", "danger", "/buckets");
}
