<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/UserController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/auth/TokenManager.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/auth/Cookie.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/middleware/AuthMiddleware.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/sanitizers.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sql/constants/users.php';

$db = Database::getInstance();
$tokenManager = new TokenManager($db);
$authMiddleware = new AuthMiddleware($tokenManager);
$userController = new UserController($db);

$authMiddleware->checkUnauthenticated();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    sanitizeString(string: sanitizeEmail($email), maxLength: EMAIL_MAX_LENGTH);
    sanitizeString(string: $password, maxLength: PASSWORD_MAX_LENGTH);

    if ($userController->login($email, $password)) {
        header("Location: /");
        exit();
    } else {
        Alerts::redirect("Invalid login credentials.", "danger", "/login");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    Alerts::display();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/views/login.php';
}
