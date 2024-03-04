<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/common/header.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/common/nav.php'; ?>
<?php Alerts::display(); ?>

<main>
    <div class="w-50 mx-auto my-5">
        <h1>Login</h1>
        <form method="post" action="/login">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
            <button class="btn btn-primary" type="submit">Login</button>
        </form>
    </div>
</main>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/views/common/footer.php'; ?>