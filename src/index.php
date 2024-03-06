<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/UserController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/auth/TokenManager.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/auth/Cookie.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/middleware/AuthMiddleware.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sql/init.php';

$db = Database::getInstance();
$tokenManager = new TokenManager($db);
$authMiddleware = new AuthMiddleware($tokenManager);

$request = $_SERVER['REQUEST_URI'];
if ($request !== '/') $request = rtrim($request, '/'); // Remove trailing slash

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
    case '/transactions/delete':
        $authMiddleware->checkUnauthenticated();
        require 'pages/transactions/delete/index.php';
        break;
    case '/transactions/delete/submit':
        $authMiddleware->checkUnauthenticated();
        require 'pages/transactions/delete/submit/index.php';
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
