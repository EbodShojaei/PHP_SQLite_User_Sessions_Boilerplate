<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/auth/TokenManager.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/auth/Cookie.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/middleware/AuthMiddleware.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/UserController.php';

$db = Database::getInstance();
$tokenManager = new TokenManager($db);
$authMiddleware = new AuthMiddleware($tokenManager);
$userController = new UserController($db);

$token = $authMiddleware->checkAuthenticated();

if ($token) {
    $user = $userController->getUser($token);
    require_once $_SERVER['DOCUMENT_ROOT'] . '/views/home/authenticated.php';
} else {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/views/home/unauthenticated.php';
}
