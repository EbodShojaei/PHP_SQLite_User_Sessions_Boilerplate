<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/auth/TokenManager.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/middleware/AuthMiddleware.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sql/constants/users.php';

$db = Database::getInstance();
$tokenManager = new TokenManager($db);
$authMiddleware = new AuthMiddleware($tokenManager);

$authMiddleware->checkUnauthenticated();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    Alerts::display();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/views/login.php';
}
