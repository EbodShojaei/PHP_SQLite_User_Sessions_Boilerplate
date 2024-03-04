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
        require 'views/login.php';
        break;
    case '/register':
        require 'views/register.php';
        break;
    case '/':
    default:
        require 'views/home.php';
        break;
}
