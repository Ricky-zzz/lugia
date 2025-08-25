<?php include __DIR__ . '/../../user/partials/head.php'; ?>

<body>
<div class="d-flex flex-column vh-100 w-100 overflow-hidden">
    <header class="w-100">
        <?php include __DIR__ . '/../../user/partials/header.php'; ?>
    </header>

    <div class="d-flex flex-grow-1 w-100 overflow-hidden">
        <aside class="bg-light border-end ps-2" style="width: 280px; flex-shrink: 0;">
            <div class="card shadow-sm mx-2 my-3">
                <div class="card-body p-3">
                    <?php
                    include __DIR__ . '/../../user/partials/filter.php';
                    renderFilterSidebar('/user/flight-routes', [
                        ['name' => 'id', 'label' => 'Route ID', 'placeholder' => 'Enter route ID'],
                        ['name' => 'oapid', 'label' => 'Origin Airport', 'placeholder' => 'Select origin'],
                        ['name' => 'dapid', 'label' => 'Destination Airport', 'placeholder' => 'Select destination'],
                        ['name' => 'acid', 'label' => 'Aircraft', 'placeholder' => 'Select aircraft'],
                        ['name' => 'round_trip', 'label' => 'Round Trip?', 'placeholder' => '0 or 1'],
                    ]);
                    ?>
                </div>
            </div>
        </aside>

        <main class="flex-grow-1 p-4 w-100 d-flex flex-column overflow-hidden" style="min-width:0;">
            <div class="content-header d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0"><i class="bi bi-map me-1"></i>Flight Routes</h2>
            </div>

            <div class="card shadow-sm w-100 flex-grow-1 d-flex flex-column overflow-hidden">
                <div class="card-body p-0 overflow-hidden d-flex flex-column">
                    <div class="table-responsive flex-grow-1">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Origin</th>
                                    <th>Destination</th>
                                    <th>Airline</th>
                                    <th>Aircraft</th>
                                    <th>Round Trip</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($routes)): ?>
                                    <?php foreach ($routes as $row): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['id']) ?></td>
                                            <td><?= htmlspecialchars($row['origin_airport']) ?>
                                                (<?= htmlspecialchars($row['origin_iata']) ?>)</td>
                                            <td><?= htmlspecialchars($row['destination_airport']) ?>
                                                (<?= htmlspecialchars($row['destination_iata']) ?>)</td>
                                            <td><?= htmlspecialchars($row['airline_name']) ?></td>
                                            <td><?= htmlspecialchars($row['aircraft_model']) ?></td>
                                            <td><?= ($row['round_trip'] ?? 0) ? 'Yes' : 'No' ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No flight routes found.</td>
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
</div>
<?php include __DIR__ . '/../../user/partials/foot.php'; ?>
</body>
