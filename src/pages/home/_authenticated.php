<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/UserController.php';

$db = Database::getInstance();
$userController = new UserController($db);
$user = $userController->getUser($_COOKIE['auth_token']);
$nickname = $user->getNickname();
?>

<main class="container vh-100">
    <div>
        <div class="mt-5">
            <h1>Welcome Back,
                <?= htmlspecialchars($nickname); ?>!
            </h1>
            <p class="my-5">
                <button class="btn btn-primary" onclick="location.href='/transactions'">Transactions</button>
                <button class="btn btn-primary" onclick="location.href='/buckets'">Buckets</button>
                <button class="btn btn-primary" onclick="location.href='/dashboard'">Dashboard</button>
            </p>
        </div>
    </div>
</main>