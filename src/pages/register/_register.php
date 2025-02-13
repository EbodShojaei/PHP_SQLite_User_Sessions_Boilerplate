<main class="container vh-100">
    <div class="w-50 mx-auto my-5">
        <h1>Register</h1>
        <form method="post" action="/register/submit">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <label for="nickname" class="form-label">Nickname</label>
                <input type="text" class="form-control" id="nickname" name="nickname" placeholder="Nickname" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>
            <button class="btn btn-primary" type="submit">Register</button>
        </form>
    </div>
</main>