<?php
$userFields = [
    ['user', 'Username', 'text'],
    ['pass', 'Password', 'password'],
    ['role', 'Role', 'select', ['admin' => 'Admin', 'user' => 'User']],
];
?>
<?php include __DIR__ . '/../../admin/partials/head.php'; ?>

<body>
<div class="d-flex flex-column vh-100 w-100 overflow-hidden">
    <header class="w-100">
        <?php include __DIR__ . '/../../admin/partials/header.php'; ?>
    </header>

    <div class="d-flex flex-grow-1 w-100 overflow-hidden">
        <aside class="bg-light border-end ps-2" style="width: 280px; flex-shrink: 0;">
            <div class="card shadow-sm mx-2 my-3">
                <div class="card-body p-3">
                    <?php
                    include __DIR__ . '/../../admin/partials/filter.php';

                    renderFilterSidebar('/admin/users', [
                        ['name' => 'user', 'label' => 'Username', 'placeholder' => 'Search username'],
                        ['name' => 'role', 'label' => 'Role', 'placeholder' => 'Enter role'],
                    ]);
                    ?>
                </div>
            </div>
        </aside>

        <main class="flex-grow-1 p-4 w-100 d-flex flex-column overflow-hidden" style="min-width:0;">
            <?php include __DIR__ . '/../../admin/partials/flash.php'; ?>
            <div class="content-header d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0"><i class="bi bi-people me-1"></i>Users</h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="bi bi-plus-circle me-2"></i>Add User
                </button>
            </div>

            <div class="card shadow-sm w-100 flex-grow-1 d-flex flex-column overflow-hidden">
                <div class="card-body p-0 overflow-hidden d-flex flex-column">
                    <div class="table-responsive flex-grow-1">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($users)): ?>
                                    <?php foreach ($users as $row): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['id'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><?= htmlspecialchars($row['user'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><?= htmlspecialchars($row['role'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                            <td class="text-nowrap">
                                                <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal"
                                                    data-bs-target="#editUserModal_<?= $row['id'] ?>">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <form action="/admin/users/delete?id=<?= $row['id'] ?>" method="post" class="d-inline">
                                                    <button class="btn btn-sm btn-outline-danger" title="Delete"
                                                            onclick="return confirm('Delete this user?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                        <?php
                                        // Edit modal for this user
                                        $modalId = "editUserModal_" . $row['id'];
                                        $title   = "Edit User";
                                        $action  = "/admin/user/update";
                                        $fields  = $userFields;
                                        $values  = $row;

                                        include __DIR__ . '/../../admin/partials/modal_form.php';
                                        ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No users found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if (isset($pages) && $pages > 1): ?>
                        <nav aria-label="Pagination">
                            <ul class="pagination mb-0">
                                <?php for ($p = 1; $p <= $pages; $p++): ?>
                                    <li class="page-item <?= $p === ($page ?? 1) ? 'active' : '' ?>">
                                        <a class="page-link" href="?page=<?= $p ?>"><?= $p ?></a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <!-- Add User Modal -->
    <?php
    $modalId = "addUserModal";
    $title   = "Add User";
    $action  = "/admin/users/store";
    $fields  = $userFields;
    $values  = []; // for add
    include __DIR__ . '/../../admin/partials/modal_form.php';
    ?>
</div>
</body>
<?php include __DIR__ . '/../../admin/partials/foot.php'; ?>
