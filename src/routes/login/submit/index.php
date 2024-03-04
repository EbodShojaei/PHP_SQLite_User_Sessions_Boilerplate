<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/sanitizers.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/UserController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/validators.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ? sanitizeEmail($_POST['email']) : '';
    $password = $_POST['password'] ? sanitizeString($_POST['password']) : '';
    validateEmail($email);
    validatePassword($password);

    $db = Database::getInstance();
    $userController = new UserController($db);

    if ($userController->login($email, $password)) {
        header("Location: /");
        exit();
    } else {
        Alerts::redirect("Invalid login credentials.", "danger", "/login");
    }
}
