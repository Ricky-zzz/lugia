<?php
// Flight Schedule fields for add/edit modals
$scheduleFields = [
    ['auid', 'Schedule Created By', 'select', array_column($airlineUsers ?? [], 'user', 'id')], // for add/edit
    ['frid', 'Flight Route', 'select', array_column($flightRoutes ?? [], 'id', 'id')],
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
                        // **Changed filter for Created By** to type=text so user can input a name
                        renderFilterSidebar('/admin/flight-schedules', [
                            ['name' => 'id', 'label' => 'Schedule ID', 'placeholder' => 'Enter schedule ID'],
                            ['name' => 'schedule_user', 'label' => 'Created By', 'placeholder' => 'Enter user name'],
                            ['name' => 'frid', 'label' => 'Flight Route', 'type' => 'select', 'options' => array_column($flightRoutes ?? [], 'id', 'id')],
                            ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['scheduled' => 'Scheduled', 'delayed' => 'Delayed', 'cancelled' => 'Cancelled', 'arrived' => 'Arrived']],
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
                <?php include __DIR__ . '/../../admin/partials/flash.php'; ?>
                <div class="content-header d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0"><i class="bi bi-clock-history me-1"></i>Flight Schedules</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addScheduleModal">
                        <i class="bi bi-plus-circle me-2"></i>Add Schedule
                    </button>
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
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($schedules)): ?>
                                        <?php foreach ($schedules as $row): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row['id']) ?></td>
                                                <td><?= htmlspecialchars($row['schedule_user']) ?></td>
                                                <td><?= htmlspecialchars($row['frid']) ?></td>
                                                <td><?= htmlspecialchars($row['airline_name']) ?></td>
                                                <td><?= htmlspecialchars($row['origin_airport']) ?>
                                                    (<?= htmlspecialchars($row['origin_iata']) ?>)</td>
                                                <td><?= htmlspecialchars($row['destination_airport']) ?>
                                                    (<?= htmlspecialchars($row['destination_iata']) ?>)</td>
                                                <td><?= htmlspecialchars($row['date_departure']) ?>
                                                    <?= htmlspecialchars($row['time_departure']) ?></td>
                                                <td><?= htmlspecialchars($row['date_arrival']) ?>
                                                    <?= htmlspecialchars($row['time_arrival']) ?></td>
                                                <td><?= htmlspecialchars(ucfirst($row['status'])) ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                        data-bs-target="#editScheduleModal_<?= $row['id'] ?>">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <form action="/admin/flight-schedules/delete?id=<?= $row['id'] ?>"
                                                        method="post" class="d-inline">
                                                        <button class="btn btn-sm btn-outline-danger" title="Delete"
                                                            onclick="return confirm('Delete this schedule?')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>

                                            <?php
                                            // Edit modal
                                            $modalId = "editScheduleModal_" . $row['id'];
                                            $title = "Edit Flight Schedule";
                                            $action = "/admin/flight-schedules/update";
                                            $fields = $scheduleFields;
                                            $values = [
                                                'id' => $row['id'],
                                                'auid' => $row['auid'],
                                                'frid' => $row['frid'],
                                                'date_departure' => $row['date_departure'],
                                                'time_departure' => $row['time_departure'],
                                                'date_arrival' => $row['date_arrival'],
                                                'time_arrival' => $row['time_arrival'],
                                                'status' => $row['status'],
                                            ];
                                            include __DIR__ . '/../../admin/partials/modal_form.php';
                                            ?>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="10" class="text-center text-muted">No flight schedules found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if (isset($pages) && $pages > 1) { ?>
                            <nav aria-label="Pagination">
                                <ul class="pagination mb-0">
                                    <?php for ($p = 1; $p <= $pages; $p++) { ?>
                                        <li class="page-item <?= $p === ($page ?? 1) ? 'active' : '' ?>">
                                            <a class="page-link" href="?page=<?= $p ?>"><?= $p ?></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </nav>
                        <?php } ?>
                    </div>
                </div>
            </main>
        </div>

        <!-- Add Schedule Modal -->
        <?php
        $modalId = "addScheduleModal";
        $title = "Add Flight Schedule";
        $action = "/admin/flight-schedules/store";
        $fields = $scheduleFields;
        $values = [];
        include __DIR__ . '/../../admin/partials/modal_form.php';
        ?>
    </div>
</body>
<?php include __DIR__ . '/../../admin/partials/foot.php'; ?>