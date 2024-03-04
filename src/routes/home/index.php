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

// Check if token exists and is valid
if ($token) {
    $userId = $tokenManager->getUserIdFromToken($token);
    if ($userId && $tokenManager->validateToken($token, $userId)) {
        // Token is valid, fetch user data and display authenticated view
        $user = $userController->getUser($userId);
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/home/authenticated.php';
    } else {
        // Token is invalid, display unauthenticated view
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/home/unauthenticated.php';
    }
} else {
    // No token, display unauthenticated view
    require_once $_SERVER['DOCUMENT_ROOT'] . '/views/home/unauthenticated.php';
}
