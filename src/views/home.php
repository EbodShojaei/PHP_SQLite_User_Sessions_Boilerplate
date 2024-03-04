<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/common/header.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/common/nav.php'; ?>
<main>
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/auth/TokenManager.php';
    $isLoggedIn = false;
    $userId = null;

    if (Cookie::exists('auth_token')) {
        $token = Cookie::get('auth_token');
        $tokenManager = new TokenManager(Database::getInstance());
        $userId = $tokenManager->getUserIdFromToken($token);
        $isLoggedIn = $userId !== null;
    }

    if ($isLoggedIn) {
        echo "<h1>Welcome, User {$userId}</h1>";
        // Display user-specific content
    } else {
        echo "<h1>Welcome to the Home Page</h1>";
        // Display generic content
    }
    ?>
</main>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/common/footer.php'; ?>