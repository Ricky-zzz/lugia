<?php include __DIR__ . '/../../airline/partials/head.php'; ?>

<body>
    <div class="d-flex flex-column vh-100 w-100">
        <header class="w-100">
            <?php include __DIR__ . '/../../airline/partials/header.php'; ?>
        </header>

        <div class="d-flex flex-grow-1 w-100 overflow-auto">
            <main class="flex-grow-1 p-4 w-100" style="min-width:0;">
                <div class="container py-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="mb-0">Seats for Flight #<?= htmlspecialchars($schedule['id']) ?></h2>
                        <a href="/airline/flight-routes/schedules?frid=<?= htmlspecialchars($schedule['frid']) ?>"
                            class="btn btn-secondary">
                            ← Back to Flight Schedules
                        </a>
                    </div>



                    <p><?= htmlspecialchars($schedule['origin_airport']) ?> →
                        <?= htmlspecialchars($schedule['destination_airport']) ?>
                    </p>

                    <?php if (!empty($seats)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Row</th>
                                        <th>Seat Number</th>
                                        <th>Class</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($seats as $seat): ?>
                                        <?php

                                        preg_match('/([A-Z]+)(\d+)/', $seat['seat_name'], $matches);
                                        $rowLetter = $matches[1] ?? '';
                                        $seatNumber = $matches[2] ?? '';
                                        ?>
                                        <tr>
                                            <td><?= htmlspecialchars($rowLetter) ?></td>
                                            <td><?= htmlspecialchars($seatNumber) ?></td>
                                            <td><?= ucfirst(htmlspecialchars($seat['class'])) ?></td>
                                            <td><?= ucfirst(htmlspecialchars($seat['status'])) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if ($totalPages > 1): ?>
                            <nav aria-label="Seat Pagination">
                                <ul class="pagination mt-3">
                                    <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                                        <li class="page-item <?= ($p === $page) ? 'active' : '' ?>">
                                            <a class="page-link" href="?fid=<?= $fid ?>&page=<?= $p ?>"><?= $p ?></a>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            </nav>
                        <?php endif; ?>

                    <?php else: ?>
                        <p>No seats found for this flight.</p>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>
</body>

<?php include __DIR__ . '/../../airline/partials/foot.php'; ?>