<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/UserController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/auth/TokenManager.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/auth/Cookie.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/middleware/AuthMiddleware.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Sanitizer.php';

$db = Database::getInstance();
$tokenManager = new TokenManager($db);
$authMiddleware = new AuthMiddleware($tokenManager);
$userController = new UserController($db);

$authMiddleware->checkUnauthenticated();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    InputSanitizer::cleanEmail($email);
    InputSanitizer::cleanString($password);

    if ($userController->login($email, $password)) {
        header("Location: /");
        exit();
    } else {
        Alerts::setAlert("Invalid login credentials.", "danger");
        header("Location: /login");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    Alerts::display();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/views/login.php';
}
