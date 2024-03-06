<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/views/common/header.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/views/common/nav.php';
    Alerts::display();
    require_once '_login.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/views/common/footer.php';
}