<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/UserController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Sanitizer.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Validator.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $email = Sanitizer::sanitizeEmail($_POST['email'] ?? '');
        $nickname = Sanitizer::sanitizeString($_POST['nickname'] ?? '');
        $password = Sanitizer::sanitizeString($_POST['password'] ?? '');

        Validator::validateEmail($email);
        Validator::validateNickname($nickname);
        Validator::validatePassword($password);

        $db = Database::getInstance();
        $userController = new UserController($db);

        if ($userController->register($email, $nickname, $password)) {
            Alerts::redirect("Registration successful. You can now log in.", "success", "/login");
            exit();
        } else {
            Alerts::redirect("Registration failed.", "danger", "/register");
        }
    } catch (Exception $e) {
        Alerts::redirect($e->getMessage(), "danger", "/register");
    }
}
