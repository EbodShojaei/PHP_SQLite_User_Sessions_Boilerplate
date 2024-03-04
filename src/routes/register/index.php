<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/config/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/UserController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/auth/TokenManager.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/auth/Cookie.php';

$db = Database::getInstance();
$userController = new UserController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $nickname = $_POST['nickname'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($userController->register($email, $nickname, $password)) {
        // Redirect to home page on successful register
        header("Location: /");
        exit();
    } else {
        // Handle login failure (e.g., show error message)
        $errorMessage = "Registration failed.";
    }
}

// After handling POST, include the view
require_once $_SERVER['DOCUMENT_ROOT'] . '/views/register.php';
