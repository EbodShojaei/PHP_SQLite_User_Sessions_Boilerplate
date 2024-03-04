<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/UserController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/auth/TokenManager.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/auth/Cookie.php';

$db = Database::getInstance();
$userController = new UserController($db);

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/login':
        require 'routes/login/index.php';
        break;
    case '/register':
        require 'routes/register/index.php';
        break;
    case '/':
    default:
        require 'routes/home/index.php';
        break;
}
