<?php
$airportFields = [
    ['iata', 'IATA', 'text'],
    ['icao', 'ICAO', 'text'],
    ['airport_name', 'Airport Name', 'text'],
    ['location_serve', 'Location Serve', 'text'],
    ['time', 'Time', 'text'],
    ['dst', 'DST', 'text'],
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

                    renderFilterSidebar('/admin/airports', [
                        ['name' => 'iata', 'label' => 'IATA', 'placeholder' => 'Enter IATA code'],
                        ['name' => 'icao', 'label' => 'ICAO', 'placeholder' => 'Enter ICAO code'],
                        ['name' => 'airport_name', 'label' => 'Airport Name', 'placeholder' => 'Enter airport name'],
                        ['name' => 'location_serve', 'label' => 'Location Serve', 'placeholder' => 'Enter location served'],
                        ['name' => 'time', 'label' => 'Time', 'placeholder' => 'Enter time'],
                        ['name' => 'dst', 'label' => 'DST', 'placeholder' => 'Enter DST'],
                    ]);
                    ?>
                </div>
            </div>
        </aside>

        <main class="flex-grow-1 p-4 w-100 d-flex flex-column overflow-hidden" style="min-width:0;">
            <?php include __DIR__ . '/../../admin/partials/flash.php'; ?>
            <div class="content-header d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0"><i class="bi bi-building me-1"></i>Airports</h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAirportModal">
                    <i class="bi bi-plus-circle me-2"></i>Add Airport
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
                                    <th>Airport Name</th>
                                    <th>Location Serve</th>
                                    <th>Time</th>
                                    <th>DST</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($airports)): ?>
                                    <?php foreach ($airports as $row): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['iata'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><?= htmlspecialchars($row['icao'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><?= htmlspecialchars($row['airport_name'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><?= htmlspecialchars($row['location_serve'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><?= htmlspecialchars($row['time'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><?= htmlspecialchars($row['dst'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                            <td class="text-nowrap">
                                                <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal"
                                                    data-bs-target="#editAirportModal_<?= $row['id'] ?>">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <form action="/admin/airports/delete?id=<?= $row['id'] ?>" method="post" class="d-inline">
                                                    <button class="btn btn-sm btn-outline-danger" title="Delete"
                                                            onclick="return confirm('Delete this airport?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                        <?php
                                        $modalId = "editAirportModal_" . $row['id'];
                                        $title   = "Edit Airport";
                                        $action  = "/admin/airports/update";
                                        $fields  = $airportFields;
                                        $values  = $row;

                                        include __DIR__ . '/../../admin/partials/modal_form.php';
                                        ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No airports found.</td>
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

    <!-- Add Airport Modal -->
    <?php
    $modalId = "addAirportModal";
    $title   = "Add Airport";
    $action  = "/admin/airports/store";
    $fields  = $airportFields;
    $values  = []; // empty for add
    include __DIR__ . '/../../admin/partials/modal_form.php';
    ?>
</div>
</body>
<?php include __DIR__ . '/../../admin/partials/foot.php'; ?>
