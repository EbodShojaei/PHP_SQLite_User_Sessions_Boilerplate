<div class="container my-5">
    <h1>Create Transaction</h1>
    <button class="btn btn-secondary mb-3" onclick="location.href='/transactions'">Back</button>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form action="create.php" method="post">
        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="expense">Expense:</label>
            <input type="number" class="form-control" id="expense" name="expense" min="0" step="0.01">
        </div>
        <div class="form-group">
            <label for="deposit">Deposit:</label>
            <input type="number" class="form-control" id="deposit" name="deposit" min="0" step="0.01">
        </div>
        <button type="submit" class="btn btn-primary my-3">Submit</button>
    </form>
</div>