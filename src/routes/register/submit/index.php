<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/sanitizers.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/UserController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/validators.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $email = sanitizeEmail($_POST['email'] ?? '');
        $nickname = sanitizeString($_POST['nickname'] ?? '');
        $password = sanitizeString($_POST['password'] ?? '');

        validateEmail($email);
        validateNickname($nickname);
        validatePassword($password);

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
