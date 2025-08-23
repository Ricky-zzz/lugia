<?php
$aircraftFields = [
    ['iata', 'IATA', 'text'],
    ['icao', 'ICAO', 'text'],
    ['model', 'Model', 'text'],
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

                    renderFilterSidebar('/admin/aircraft', [
                        ['name' => 'iata', 'label' => 'IATA', 'placeholder' => 'Enter IATA code'],
                        ['name' => 'icao', 'label' => 'ICAO', 'placeholder' => 'Enter ICAO code'],
                        ['name' => 'model', 'label' => 'Model', 'placeholder' => 'Enter model'],
                    ]);
                    ?>
                </div>
            </div>
        </aside>

        <main class="flex-grow-1 p-4 w-100 d-flex flex-column overflow-hidden" style="min-width:0;">
            <?php include __DIR__ . '/../../admin/partials/flash.php'; ?>
            <div class="content-header d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0"><i class="bi bi-airplane me-1"></i>Aircraft</h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAircraftModal">
                    <i class="bi bi-plus-circle me-2"></i>Add Aircraft
                </button>
            </div>

            <div class="card shadow-sm w-100 flex-grow-1 d-flex flex-column overflow-hidden">
                <div class="card-body p-0 overflow-hidden d-flex flex-column">
                    <div class="table-responsive flex-grow-1">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>IATA</th>
                                    <th>ICAO</th>
                                    <th>Model</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($aircrafts)): ?>
                                    <?php foreach ($aircrafts as $row): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['iata'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><?= htmlspecialchars($row['icao'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><?= htmlspecialchars($row['model'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                            <td class="text-nowrap">
                                                <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal"
                                                    data-bs-target="#editAircraftModal_<?= $row['id'] ?>">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <form action="/admin/aircraft/delete?id=<?= $row['id'] ?>" method="post" class="d-inline">
                                                    <button class="btn btn-sm btn-outline-danger" title="Delete"
                                                            onclick="return confirm('Delete this aircraft?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                        <?php
                                        // Generate edit modal for this row
                                        $modalId = "editAircraftModal_" . $row['id'];
                                        $title   = "Edit Aircraft";
                                        $action  = "/admin/aircraft/update";
                                        $fields  = $aircraftFields;
                                        $values  = $row;

                                        include __DIR__ . '/../../admin/partials/modal_form.php';
                                        ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No aircraft found.</td>
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

    <!-- Add Aircraft Modal -->
    <?php
    $modalId = "addAircraftModal";
    $title   = "Add Aircraft";
    $action  = "/admin/aircraft/store";
    $fields  = $aircraftFields;
    $values  = []; // empty for add
    include __DIR__ . '/../../admin/partials/modal_form.php';
    ?>
</div>
</body>
<?php include __DIR__ . '/../../admin/partials/foot.php'; ?>
