<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/BucketController.php';
    $db = Database::getInstance();
    $bucketController = new BucketController($db);
    $buckets = $bucketController->getAllBuckets();
    
    require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/_common/_header.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/_common/_nav.php';
    Alerts::display();
    require_once '_buckets.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/_common/_footer.php';
}
 