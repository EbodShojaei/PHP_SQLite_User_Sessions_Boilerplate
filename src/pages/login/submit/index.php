<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/UserController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Sanitizer.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Validator.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $email = $_POST['email'] ? Sanitizer::sanitizeEmail($_POST['email']) : '';
        $password = $_POST['password'] ? Sanitizer::sanitizeString($_POST['password']) : '';
        Validator::validateEmail($email);
        Validator::validatePassword($password);

        $db = Database::getInstance();
        $userController = new UserController($db);

        if ($userController->login($email, $password)) {
            header("Location: /");
            exit();
        } else {
            Alerts::redirect("Invalid login credentials.", "danger", "/login");
        }
    } catch (Exception $e) {
        Alerts::redirect($e->getMessage(), "danger", "/login");
    }
}
