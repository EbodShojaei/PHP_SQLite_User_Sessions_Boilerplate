<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/_common/_header.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/_common/_nav.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/buckets/update/index.php';
    $db = Database::getInstance();
    $sql = "SELECT * FROM buckets";
    $buckets = $db->execute($sql) ?? [];
    Alerts::display();
    require_once '_buckets.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/_common/_footer.php';
}
