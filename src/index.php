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

switch ($request) {
    case '/login':
        $authMiddleware->checkAuthenticated();
        require 'routes/login/index.php';
        break;
    case '/login/submit':
        $authMiddleware->checkAuthenticated();
        require 'routes/login/submit/index.php';
        break;
    case '/register':
        $authMiddleware->checkAuthenticated();
        require 'routes/register/index.php';
        break;
    case '/register/submit':
        $authMiddleware->checkAuthenticated();
        require 'routes/register/submit/index.php';
        break;
    case '/logout':
        require 'routes/logout/index.php';
        break;
    case '/':
        $isAuthenticated = $authMiddleware->isAuthenticated();
        require 'routes/home/index.php';
        break;
    case '/admin':
        $authMiddleware->checkAuthorized();
        require 'routes/admin/index.php';
        break;
    case '/admin/activate':
        $authMiddleware->checkAuthorized();
        require 'routes/admin/activate/index.php';
        break;
    case '/admin/deactivate':
        $authMiddleware->checkAuthorized();
        require 'routes/admin/deactivate/index.php';
        break;
    default:
        require 'routes/error/404/index.php';
        break;
}
