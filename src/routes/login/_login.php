<main class="container vh-100">
    <div class="w-50 mx-auto my-5">
        <h1>Login</h1>
        <form method="post" action="/login/submit">
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