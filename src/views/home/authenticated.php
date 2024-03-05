<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/common/header.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/common/nav.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/UserController.php'; ?>

<?php
$db = Database::getInstance();
$userController = new UserController($db);
$user = $userController->getUser(token: $_COOKIE['auth_token']);
$nickname = $user->getNickname();
?>

<main class="container vh-100">
    <div>
        <div class="mt-5">
        <h1>Welcome Back, <?= htmlspecialchars($nickname); ?>!</h1>
        <p>This is your dashboard where you can access all your personal features.</p>
        <!-- Additional content for authenticated users -->
        </div>
    </div>
</main>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/common/footer.php'; ?>