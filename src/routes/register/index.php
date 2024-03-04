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
    $nickname = $_POST['nickname'] ?? '';
    $password = $_POST['password'] ?? '';
    InputSanitizer::cleanEmail($email);
    InputSanitizer::cleanString($nickname);
    InputSanitizer::cleanString($password);

    if ($userController->register($email, $nickname, $password)) {
        header("Location: /");
        exit();
    } else {
        Alerts::setAlert("Registration failed.", "danger");
        header("Location: /register");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    Alerts::display();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/views/register.php';
}
