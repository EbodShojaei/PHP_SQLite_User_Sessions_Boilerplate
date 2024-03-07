<div class="container my-5">
    <h1 class="my-5">Buckets</h1>
    <button class="btn btn-secondary mb-3" onclick="location.href='/'">Back</button>
    <button class="btn btn-primary mb-3" onclick="location.href='/buckets/create'">Create Bucket</button>

    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>Bucket ID</th>
                <th>Transaction Name</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (is_array($buckets) || is_object($buckets)) ?>
            <?php foreach ($buckets as $bucket): ?>
                <tr>
                    <td>
                        <?= htmlspecialchars($bucket['bucket_id']) ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($bucket['transaction_name']) ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($bucket['category']) ?>
                    </td>
                    <td>
                        <button class="btn btn-info"
                            onclick="location.href='/buckets/update?id=<?= $bucket['bucket_id'] ?>'">Update</button>
                        <button class="btn btn-danger"
                            onclick="confirmDelete('<?= $bucket['bucket_id'] ?>')">Delete</button>
                        <form id="deleteForm_<?= $bucket['bucket_id'] ?>" action="/buckets/remove" method="post"
                            style="display:none;">
                            <input type="hidden" name="bucket_id" value="<?= $bucket['bucket_id'] ?>">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <div id="deleteModal" style="display:none;">
                <form action="/buckets/remove" method="post">
                    <input type="hidden" name="bucket_id" id="bucketToDelete" value="">
                    <p>Are you sure you want to delete this bucket?</p>
                    <input type="submit" value="Confirm Delete">
                </form>
            </div>
        </tbody>
    </table>
</div>

<script>
    function confirmDelete(bucketId) {
        if (confirm("Are you sure you want to delete this bucket?")) {
            document.getElementById('deleteForm_' + bucketId).submit();
        }
    }
</script>