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
                        <?= htmlspecialchars($transaction['trans_id']) ?>
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
                            onclick="document.getElementById('updateForm_<?= $transaction['trans_id'] ?>').submit();">Update</button>
                        <form id="updateForm_<?= $transaction['trans_id'] ?>"
                            action="/transactions/update?id=<?= $transaction['trans_id'] ?>" method="post" style="display:none;">
                            <input type="hidden" name="trans_id" value="<?= $transaction['trans_id'] ?>">
                        </form>
                        <button class="btn btn-danger" onclick="confirmDelete('<?= $transaction['trans_id'] ?>')">Delete</button>
                        <form id="deleteForm_<?= $transaction['trans_id'] ?>" action="/transactions/remove" method="post"
                            style="display:none;">
                            <input type="hidden" name="trans_id" value="<?= $transaction['trans_id'] ?>">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <div id="deleteModal" style="display:none;">
                <form action="/transactions/remove" method="post">
                    <input type="hidden" name="trans_id" id="transactionToDelete" value="">
                    <p>Are you sure you want to delete this transaction?</p>
                    <input type="submit" value="Confirm Delete">
                </form>
            </div>
        </tbody>
    </table>
</div>
<script>
    function confirmDelete(transactionId) {
        if (confirm("Are you sure you want to delete this transaction?")) {
            document.getElementById('deleteForm_' + transactionId).submit();
        }
    }
</script>