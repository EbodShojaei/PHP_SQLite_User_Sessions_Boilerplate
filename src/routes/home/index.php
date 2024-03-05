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

$token = Cookie::exists('auth_token') ? Cookie::get('auth_token') : null;
$isAuthenticated = $authMiddleware->checkAuthenticated($token);
$isActivated = $isAuthenticated ? $tokenManager->getUserStatusFromToken($token) === 'active' : false;
$validToken = $isAuthenticated ? $tokenManager->validateToken($token) : false;

if ($token && $isAuthenticated && $isActivated && $validToken) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/views/home/authenticated.php';
} else {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/views/home/unauthenticated.php';
}
