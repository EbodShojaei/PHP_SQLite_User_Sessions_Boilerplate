<div class="container my-5">
    <h1 class="my-5">Transactions</h1>
    <button class="btn btn-secondary mb-3" onclick="location.href='/'">Back</button>
    <button class="btn btn-primary mb-3" onclick="location.href='/transactions/create'">Create Transaction</button>

    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Name</th>
                <th>Expense</th>
                <th>Deposit</th>
                <th>Overall Balance</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $transaction): ?>
                <tr>
                    <td>
                        <?= htmlspecialchars($transaction['id']) ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($transaction['date']) ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($transaction['name']) ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($transaction['expense']) ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($transaction['deposit']) ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($transaction['balance']) ?>
                    </td>
                    <td>
                        <?= empty($transaction['category']) ? 'Other' : htmlspecialchars($transaction['category']) ?>
                    </td>
                    <td>
                        <button class="btn btn-info"
                            onclick="location.href='/transactions/update/<?= $transaction['id'] ?>'">Update</button>
                        <button class="btn btn-danger"
                            onclick="confirmDelete('<?= $transaction['id'] ?>')">Delete</button>
                        <form id="deleteForm_<?= $transaction['id'] ?>" action="/transactions/remove"
                            method="post" style="display:none;">
                            <input type="hidden" name="id" value="<?= $transaction['id'] ?>">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <div id="deleteModal" style="display:none;">
                <form action="/transactions/remove" method="post">
                    <input type="hidden" name="id" id="transactionToDelete" value="">
                    <p>Are you sure you want to delete this transaction?</p>
                    <input type="submit" value="Confirm Delete">
                    <!-- Include a CSRF token here -->
                </form>
            </div>
        </tbody>
    </table>
</div>
<script>
    function confirmDelete(transactionId) {
        if (confirm("Are you sure you want to delete this transaction?")) {
            // Submit the form corresponding to the transaction
            document.getElementById('deleteForm_' + transactionId).submit();
        }
    }
</script>