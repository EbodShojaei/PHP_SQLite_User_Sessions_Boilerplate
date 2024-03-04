<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/common/header.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/common/nav.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/controllers/UserController.php'; ?>

<?php
$db = Database::getInstance();
$userController = new UserController($db);
$user = $userController->getUser(token: $_COOKIE['auth_token']);
$nickname = $user->getNickname();
?>

<main>
    <div class="container">
        <h1>Welcome Back, <?= htmlspecialchars($nickname); ?>!</h1>
        <p>This is your dashboard where you can access all your personal features.</p>
        <!-- Additional content for authenticated users -->
    </div>
</main>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/common/footer.php'; ?>