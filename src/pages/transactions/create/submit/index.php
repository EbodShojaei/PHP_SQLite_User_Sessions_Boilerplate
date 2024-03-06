<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/TransactionController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Sanitizer.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Validator.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $date = Sanitizer::sanitizeString($_POST['date'] ??'');
        $name = Sanitizer::sanitizeString($_POST['name'] ??'');
        $expense = floatval(Sanitizer::sanitizeString($_POST['expense'] ?? ''));
        $deposit = floatval(Sanitizer::sanitizeString($_POST['deposit'] ??''));
        



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
