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
                <th>Income</th>
                <th>Overall Balance</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $transaction): ?>
                <tr>
                    <td>
                        <?= htmlspecialchars($transaction['transaction_id']) ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($transaction['transaction_date']) ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($transaction['name']) ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($transaction['expense']) ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($transaction['income']) ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($transaction['overall_balance']) ?>
                    </td>
                    <td>
                        <?= empty($transaction['category']) ? 'Other' : htmlspecialchars($transaction['category']) ?>
                    </td>
                    <td>
                        <button class="btn btn-info"
                            onclick="location.href='/transactions/update/<?= $transaction['transaction_id'] ?>'">Update</button>
                        <button class="btn btn-danger"
                            onclick="location.href='/transactions/delete/<?= $transaction['transaction_id'] ?>'">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>