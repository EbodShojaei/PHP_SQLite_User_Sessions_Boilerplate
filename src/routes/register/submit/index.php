<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/sanitizers.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/UserController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/validators.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $email = sanitizeEmail($_POST['email'] ?? '', "/register");
        $nickname = sanitizeString($_POST['nickname'] ?? '', "/register");
        $password = sanitizeString($_POST['password'] ?? '', "/register");

        validateEmail($email, "/register");
        validateNickname($nickname, "/register");
        validatePassword($password, "/register");

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
