<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/BucketController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/auth/TokenManager.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $db = Database::getInstance();
    $bucketController = new BucketController($db);
    $bucketId = $_GET['id'] ?? Alerts::redirect("Bucket ID is required", "danger", "/buckets");
    $bucket = $bucketController->getBucketById($bucketId) ?? Alerts::redirect("Bucket not found", "danger", "/buckets");

    require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/_common/_header.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/_common/_nav.php';
    Alerts::display();
    require_once '_update.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/_common/_footer.php';
}