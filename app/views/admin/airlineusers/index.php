<?php
$airlineUserFields = [
    ['user', 'Username', 'text'],
    ['pass', 'Password', 'password'],
    ['type', 'Role', 'select', [
    'admin'  => 'Admin',
    'staff'  => 'Staff',
    'pilot'  => 'Pilot'
]],

    ['aid', 'Airline', 'select', array_column($airlines, 'airline_name', 'id')], // maps [id => airline_name]dropdown from airlines
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

                        renderFilterSidebar('/admin/airline-users', [
                            ['name' => 'user', 'label' => 'Username', 'placeholder' => 'Enter username'],
                            ['name' => 'type', 'label' => 'Type', 'placeholder' => 'Enter user type'],
                        ]);
                        ?>
                    </div>
                </div>
            </aside>

            <main class="flex-grow-1 p-4 w-100 d-flex flex-column overflow-hidden" style="min-width:0;">
                <?php include __DIR__ . '/../../admin/partials/flash.php'; ?>
                <div class="content-header d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0"><i class="bi bi-people me-1"></i> Airline Users</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAirlineUserModal">
                        <i class="bi bi-plus-circle me-2"></i>Add User
                    </button>
                </div>

                <div class="card shadow-sm w-100 flex-grow-1 d-flex flex-column overflow-hidden">
                    <div class="card-body p-0 overflow-hidden d-flex flex-column">
                        <div class="table-responsive flex-grow-1">
                            <table class="table table-hover table-striped align-middle mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>Type</th>
                                        <th>Airline</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($airlineUsers)): ?>
                                        <?php foreach ($airlineUsers as $row): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row['user'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                <td><?= htmlspecialchars($row['pass'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                <td><?= htmlspecialchars($row['type'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                                <td><?= htmlspecialchars($row['airline_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                                </td>
                                                <td class="text-nowrap">
                                                    <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal"
                                                        data-bs-target="#editAirlineUserModal_<?= $row['id'] ?>">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <form action="/admin/airline-users/delete?id=<?= $row['id'] ?>" method="post"
                                                        class="d-inline">
                                                        <button class="btn btn-sm btn-outline-danger" title="Delete"
                                                            onclick="return confirm('Delete this user?')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>

                                            <?php
                                            // Edit modal
                                            $modalId = "editAirlineUserModal_" . $row['id'];
                                            $title = "Edit Airline User";
                                            $action = "/admin/airline-users/update";
                                            $fields = $airlineUserFields;
                                            $values = $row;

                                            include __DIR__ . '/../../admin/partials/modal_form.php';
                                            ?>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">No users found.</td>
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

        <!-- Add Airline User Modal -->
        <?php
        $modalId = "addAirlineUserModal";
        $title = "Add Airline User";
        $action = "/admin/airline-users/store";
        $fields = $airlineUserFields;
        $values = []; // empty for add
        include __DIR__ . '/../../admin/partials/modal_form.php';
        ?>
    </div>
</body>
<?php include __DIR__ . '/../../admin/partials/foot.php'; ?>