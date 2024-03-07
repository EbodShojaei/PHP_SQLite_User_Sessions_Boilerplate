<div class="container my-5">
    <h1 class="my-5">Update Transaction</h1>
    <a href="/transactions" class="btn btn-secondary">Back</a>
    <hr>
    <form action="/transactions/update/submit" method="post">
        <div class="form-group">
            <label for="id">ID:</label>
            <input type="text" class="form-control" id="id" name="id" value="<?php echo htmlspecialchars($transaction['trans_id']); ?>"
                disabled>
        </div>
        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" class="form-control" id="date" name="date"
                value="<?php echo htmlspecialchars($transaction['date']); ?>" required>
        </div>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name"
                value="<?php echo htmlspecialchars($transaction['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="expense">Expense:</label>
            <input type="number" class="form-control" id="expense" name="expense"
                value="<?php echo htmlspecialchars($transaction['expense']); ?>" min="0" step="0.01">
        </div>
        <div class="form-group">
            <label for="deposit">Deposit:</label>
            <input type="number" class="form-control" id="deposit" name="deposit"
                value="<?php echo htmlspecialchars($transaction['deposit']); ?>" min="0" step="0.01">
        </div>
        <button type="submit" class="btn btn-primary my-3">Update</button>
    </form>
</div>