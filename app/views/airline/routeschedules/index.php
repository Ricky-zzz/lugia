<?php
$aid = $_SESSION['aid'] ?? null;
$frid = $_POST['frid'] ?? $_GET['frid'] ?? $_SESSION['current_frid'] ?? null;


// Flight Schedule fields for add/edit modals
$scheduleFields = [

    ['date_departure', 'Departure Date', 'date'],
    ['time_departure', 'Departure Time', 'time'],
    ['date_arrival', 'Arrival Date', 'date'],
    ['time_arrival', 'Arrival Time', 'time'],
    [
        'status',
        'Status',
        'select',
        [
            'scheduled' => 'Scheduled',
            'delayed' => 'Delayed',
            'cancelled' => 'Cancelled',
            'arrived' => 'Arrived'
        ]
    ],
    ['frid', '', 'hidden', []],  // Change this line
];

// current airline id from session
$currentAirlineId = $_SESSION['aid'] ?? null;
?>

<?php include __DIR__ . '/../../airline/partials/head.php'; ?>

<body>
    <div class="d-flex flex-column vh-100 w-100 overflow-hidden">
        <header class="w-100">
            <?php include __DIR__ . '/../../airline/partials/header.php'; ?>
        </header>

        <div class="d-flex flex-grow-1 w-100 overflow-hidden">
            <aside class="bg-light border-end ps-2" style="width: 280px; flex-shrink: 0;">
                <div class="card shadow-sm mx-2 my-3">
                    <div class="card-body p-3">
                        <?php
                        include __DIR__ . '/../../airline/partials/filter.php';
                        
                        renderFilterSidebar("/airline/flight-routes/schedules?frid=$frid", [
                            ['name' => 'frid','label' => 'frid', 'type' => 'hidden', 'value' => $frid],
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
                <?php include __DIR__ . '/../../airline/partials/flash.php'; ?>
                <div class="content-header d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0"><i class="bi bi-clock-history me-1"></i>Flight Schedules</h2>

                    <?php if ($currentAirlineId): ?>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addScheduleModal">
                            <i class="bi bi-plus-circle me-2"></i>Add Schedule
                        </button>
                    <?php endif; ?>
                </div>

                <div class="card shadow-sm w-100 flex-grow-1 d-flex flex-column overflow-hidden">
                    <div class="card-body p-0 overflow-hidden d-flex flex-column">
                        <div class="table-responsive flex-grow-1">
                            <table class="table table-hover table-striped align-middle mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Airline</th>
                                        <th>Origin</th>
                                        <th>Destination</th>
                                        <th>Departure</th>
                                        <th>Arrival</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($schedules)): ?>
                                        <?php foreach ($schedules as $row): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row['airline_name'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($row['origin_airport'] ?? '') ?>
                                                    (<?= htmlspecialchars($row['origin_iata'] ?? '') ?>)</td>
                                                <td><?= htmlspecialchars($row['destination_airport'] ?? '') ?>
                                                    (<?= htmlspecialchars($row['destination_iata'] ?? '') ?>)</td>
                                                <td><?= htmlspecialchars($row['date_departure'] ?? '') ?>
                                                    <?= htmlspecialchars($row['time_departure'] ?? '') ?>
                                                </td>
                                                <td><?= htmlspecialchars($row['date_arrival'] ?? '') ?>
                                                    <?= htmlspecialchars($row['time_arrival'] ?? '') ?>
                                                </td>
                                                <td><?= htmlspecialchars(ucfirst($row['status'] ?? '')) ?></td>
                                                <td>
                                                    <?php if ($row['airline_id'] == $currentAirlineId): ?>
                                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                            data-bs-target="#editScheduleModal_<?= $row['id'] ?>">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        <form action="/airline/flight-routes/schedules/delete?id=<?= $row['id'] ?>"
                                                            method="post" class="d-inline">
                                                            <button class="btn btn-sm btn-outline-danger" title="Delete"
                                                                onclick="return confirm('Delete this schedule?')">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>

                                                        <?php
                                                        // Edit modal (only if same airline)
                                                        $modalId = "editScheduleModal_" . $row['id'];
                                                        $title = "Edit Flight Schedule";
                                                        $action = "/airline/flight-routes/schedules/update";
                                                        $fields = $scheduleFields;
                                                        $values = [
                                                            'id' => $row['id'],
                                                            'date_departure' => $row['date_departure'],
                                                            'time_departure' => $row['time_departure'],
                                                            'date_arrival' => $row['date_arrival'],
                                                            'time_arrival' => $row['time_arrival'],
                                                            'status' => $row['status'],
                                                        ];
                                                        include __DIR__ . '/../../admin/partials/modal_form.php';
                                                        ?>
                                                    <?php else: ?>
                                                        <span class="text-muted small">View only</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">No flight schedules found.</td>
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

        <!-- Add Schedule Modal -->
        <?php if ($currentAirlineId): ?>
            <?php
            $modalId = "addScheduleModal";
            $title = "Add Flight Schedule";
            $action = "/airline/flight-routes/schedules/store";
            $fields = $scheduleFields;
            $values = ['frid' => $frid];  // Make sure frid is set here
            include __DIR__ . '/../../airline/partials/modal_form.php';
            ?>
        <?php endif; ?>
    </div>
</body>
<?php include __DIR__ . '/../../airline/partials/foot.php'; ?>