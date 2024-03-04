<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/UserController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/auth/TokenManager.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/auth/Cookie.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/middleware/AuthMiddleware.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';

$db = Database::getInstance();
$tokenManager = new TokenManager($db);
$authMiddleware = new AuthMiddleware($tokenManager);
$userController = new UserController($db);

$authMiddleware->checkUnauthenticated();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($userController->login($email, $password)) {
        header("Location: /");
        exit();
    } else {
        Alerts::setAlert("Invalid login credentials.", "error");
        header("Location: /login");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $alert = Alerts::getAlert();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/views/login.php';
}
