<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/UserController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';

$cookie = $_COOKIE['auth_token'] ?? '';
$db = Database::getInstance();
$tokenManager = new TokenManager($db);
$userController = new UserController($db);
$userId = $tokenManager->getUserIdFromToken($cookie);
$userController->logout($userId);

// Redirect to the login page or home page
header('Location: /');
exit;
