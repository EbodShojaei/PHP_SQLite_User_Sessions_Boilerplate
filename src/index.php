<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/UserController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/auth/TokenManager.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/auth/Cookie.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/auth/AuthMiddleware.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sql/init.php';

$db = Database::getInstance();
$tokenManager = new TokenManager($db);
$authMiddleware = new AuthMiddleware($tokenManager);

$request = $_SERVER['REQUEST_URI'];
if ($request !== '/')
    $request = rtrim($request, '/'); // Remove trailing slash

if (strpos($request, '/transactions/update') === 0) {
    $authMiddleware->checkUnauthenticated();
    require 'pages/transactions/update/index.php';
} elseif (strpos($request, '/transactions/update/submit') === 0) {
    $authMiddleware->checkUnauthenticated();
    require 'pages/transactions/update/submit/index.php';
} elseif (strpos($request, '/buckets/update') === 0) {
    $authMiddleware->checkUnauthenticated();
    require 'pages/buckets/update/index.php';
} elseif (strpos($request, '/buckets/update/submit') === 0) {
    $authMiddleware->checkUnauthenticated();
    require 'pages/buckets/update/submit/index.php';
} else {
    switch ($request) {
        case '/login':
            $authMiddleware->checkAuthenticated();
            require 'pages/login/index.php';
            break;
        case '/login/submit':
            $authMiddleware->checkAuthenticated();
            require 'pages/login/submit/index.php';
            break;
        case '/register':
            $authMiddleware->checkAuthenticated();
            require 'pages/register/index.php';
            break;
        case '/register/submit':
            $authMiddleware->checkAuthenticated();
            require 'pages/register/submit/index.php';
            break;
        case '/logout':
            require 'pages/logout/index.php';
            break;
        case '/':
            $isAuthenticated = $authMiddleware->isAuthenticated();
            require 'pages/home/index.php';
            break;
        case '/transactions':
            $authMiddleware->checkUnauthenticated();
            require 'pages/transactions/index.php';
            break;
        case '/transactions/create':
            $authMiddleware->checkUnauthenticated();
            require 'pages/transactions/create/index.php';
            break;
        case '/transactions/create/submit':
            $authMiddleware->checkUnauthenticated();
            require 'pages/transactions/create/submit/index.php';
            break;
        case '/transactions/update':
            $authMiddleware->checkUnauthenticated();
            require 'pages/transactions/update/index.php';
            break;
        case '/transactions/update/submit':
            $authMiddleware->checkUnauthenticated();
            require 'pages/transactions/update/submit/index.php';
            break;
        case '/transactions/remove':
            $authMiddleware->checkUnauthenticated();
            require 'pages/transactions/remove/index.php';
            break;
        case '/buckets':
            $authMiddleware->checkUnauthenticated();
            require 'pages/buckets/index.php';
            break;
        case '/buckets/create':
            $authMiddleware->checkUnauthenticated();
            require 'pages/buckets/create/index.php';
            break;
        case '/buckets/create/submit':
            $authMiddleware->checkUnauthenticated();
            require 'pages/buckets/create/submit/index.php';
            break;
        case '/buckets/remove':
            $authMiddleware->checkUnauthenticated();
            require 'pages/buckets/remove/index.php';
            break;
        case '/buckets/update':
            $authMiddleware->checkUnauthenticated();
            require 'pages/buckets/update/index.php';
            break;
        case '/buckets/update/submit':
            $authMiddleware->checkUnauthenticated();
            require 'pages/buckets/update/submit/index.php';
            break;
        case '/admin':
            $authMiddleware->checkAuthorized();
            require 'pages/admin/index.php';
            break;
        case '/admin/activate':
            $authMiddleware->checkAuthorized();
            require 'pages/admin/activate/index.php';
            break;
        case '/admin/deactivate':
            $authMiddleware->checkAuthorized();
            require 'pages/admin/deactivate/index.php';
            break;
        default:
            require 'pages/error/404/index.php';
            break;
    }
}
