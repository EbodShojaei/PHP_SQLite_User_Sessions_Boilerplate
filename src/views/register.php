<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/common/header.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/common/nav.php'; ?>
<main>
    <h1>Register</h1>
    <form method="post" action="/register">
        <input type="email" name="email" placeholder="Email">
        <input type="text" name="nickname" placeholder="Nickname">
        <input type="password" name="password" placeholder="Password">
        <button type="submit">Register</button>
    </form>
</main>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/common/footer.php'; ?>