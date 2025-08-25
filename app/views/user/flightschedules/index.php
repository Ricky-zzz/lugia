<?php
// User flight schedules index
$scheduleFields = []; // not used for user view
$currentAirlineId = $_SESSION['aid'] ?? null; // can be ignored if users don't edit
?>

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
                        renderFilterSidebar('/user/flight-schedules', [
                            ['name' => 'id', 'label' => 'Schedule ID', 'placeholder' => 'Enter schedule ID'],
                            ['name' => 'schedule_user', 'label' => 'Created By', 'placeholder' => 'Enter user name'],
                            ['name' => 'frid', 'label' => 'Flight Route', 'type' => 'select', 'options' => array_column($flightRoutes ?? [], 'id', 'id')],
                            [
                                'name' => 'status',
                                'label' => 'Status',
                                'type' => 'select',
                                'options' => [
                                    'scheduled' => 'Scheduled',
                                    'delayed' => 'Delayed',
                                    'cancelled' => 'Cancelled',
                                    'arrived' => 'Arrived'
                                ]
                            ],
                            ['name' => 'date_departure_from', 'label' => 'Departure From', 'type' => 'date'],
                            ['name' => 'date_departure_to', 'label' => 'Departure To', 'type' => 'date'],
                            ['name' => 'date_arrival_from', 'label' => 'Arrival From', 'type' => 'date'],
                            ['name' => 'date_arrival_to', 'label' => 'Arrival To', 'type' => 'date'],
                        ]);
                        ?>
                    </div>
                </div>
            </aside>

            <main class="flex-grow-1 p-4 w-100 d-flex flex-column overflow-hidden" style="min-width:0;">
                <?php include __DIR__ . '/../../user/partials/flash.php'; ?>
                <div class="content-header mb-4">
                    <h2 class="mb-0"><i class="bi bi-clock-history me-1"></i>Flight Schedules</h2>
                </div>

                <div class="card shadow-sm w-100 flex-grow-1 d-flex flex-column overflow-hidden">
                    <div class="card-body p-0 overflow-hidden d-flex flex-column">
                        <div class="table-responsive flex-grow-1">
                            <table class="table table-hover table-striped align-middle mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Created By</th>
                                        <th>Flight Route</th>
                                        <th>Airline</th>
                                        <th>Origin</th>
                                        <th>Destination</th>
                                        <th>Departure</th>
                                        <th>Arrival</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($schedules)): ?>
                                        <?php foreach ($schedules as $row): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row['id'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($row['schedule_user'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($row['frid'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($row['airline_name'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($row['origin_airport'] ?? '') ?> (<?= htmlspecialchars($row['origin_iata'] ?? '') ?>)</td>
                                                <td><?= htmlspecialchars($row['destination_airport'] ?? '') ?> (<?= htmlspecialchars($row['destination_iata'] ?? '') ?>)</td>
                                                <td><?= htmlspecialchars($row['date_departure'] ?? '') ?> <?= htmlspecialchars($row['time_departure'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($row['date_arrival'] ?? '') ?> <?= htmlspecialchars($row['time_arrival'] ?? '') ?></td>
                                                <td><?= htmlspecialchars(ucfirst($row['status'] ?? '')) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="9" class="text-center text-muted">No flight schedules found.</td>
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
