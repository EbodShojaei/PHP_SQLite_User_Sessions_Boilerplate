<div class="container my-5">
    <h1 class = "my-5">Create Bucket</h1>
    <button class="btn btn-secondary mb-3" onclick="location.href='/buckets'">Back</button>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form action="/buckets/create/submit" method="post">
        <div class="form-group">
            <label for="transaction_name">Transaction:</label>
            <input type="text" class="form-control" id="transaction_name" name="transaction_name" required>
        </div>
        <div class="form-group">
            <label for="category">Category:</label>
            <input type="text" class="form-control" id="category" name="category" required>
        </div>
        <button type="submit" class="btn btn-primary my-3">Submit</button>
    </form>
</div>