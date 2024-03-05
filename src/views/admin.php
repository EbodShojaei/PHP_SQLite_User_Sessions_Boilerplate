<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/helpers/Alerts.php'; ?>
<?php Alerts::display(); ?>

<main>
    <div class="container my-5">
        <h1 class="my-5">Admin</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Nickname</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['email'] ?></td>
                        <td><?= $user['nickname'] ?></td>
                        <td><?= $user['role'] ?></td>
                        <td><?= $user['status'] ?></td>
                        <td>
                            <form method="POST" action="/admin/activate">
                                <input type="hidden" name="userId" value="<?= $user['id'] ?>">
                                <button class="btn btn-success m-1 w-50" type="submit">Activate</button>
                            </form>
                            <form method="POST" action="/admin/deactivate">
                                <input type="hidden" name="userId" value="<?= $user['id'] ?>">
                                <button class="btn btn-danger m-1 w-50" type="submit">Deactivate</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <nav aria-label="users-list">
            <ul class="pagination justify-content-center py-5 my-5 fixed-bottom">
                <?php if ($currentPage > 1): ?>
                    <li class="page-item"><a class="page-link" href="?page=1">First</a></li>
                    <li class="page-item"><a class="page-link" href="?page=<?= $currentPage - 1 ?>">Previous</a></li>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
                <?php endfor; ?>
                <?php if ($currentPage < $totalPages): ?>
                    <li class="page-item"><a class="page-link" href="?page=<?= $currentPage + 1 ?>">Next</a></li>
                    <li class="page-item"><a class="page-link" href="?page=<?= $totalPages ?>">Last</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</main>