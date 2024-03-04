<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/common/header.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/common/nav.php'; ?>
<main>
    <h1>Login</h1>
    <form method="post" action="/login">
        <input type="email" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <button type="submit">Login</button>
    </form>
</main>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/common/footer.php'; ?>