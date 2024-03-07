<div class="container my-5">
    <h1 class="my-5">Update Bucket</h1>
    <a href="/buckets" class="btn btn-secondary">Back</a>
    <hr>
    <!-- THIS WAS PROBLEMATIC WITHOUT /pages -->
    <form action="/pages/buckets/update/submit" method="post">
        <div class="form-group">
            <input type="hidden" name="bucket_id" value="<?= htmlspecialchars($bucket['bucket_id']); ?>">
        </div>
        <div class="form-group">
            <label for="transaction_name">Transaction Name:</label>
            <input type="text" class="form-control" id="transaction_name" name="transaction_name"
                value="<?= htmlspecialchars($bucket['transaction_name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="category">Category:</label>
            <input type="text" class="form-control" id="category" name="category"
                value="<?= htmlspecialchars($bucket['category']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary my-3">Update</button>
    </form>
</div>