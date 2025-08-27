<?php
// Detect current path (e.g. "/admin/airlines")
$current = $_SERVER['REQUEST_URI'];
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand fw-bold" href="/admin/dashboard">Lugia</a>

        <!-- Toggler for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link <?= str_contains($current, '/admin/airlines') ? 'active' : '' ?>"
                        href="/admin/airlines">
                        <i class="bi bi-airplane me-1"></i>Airline
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= str_contains($current, '/admin/aircraft') ? 'active' : '' ?>"
                        href="/admin/aircraft">
                        <i class="bi bi-airplane-fill me-1"></i>Aircraft
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= str_contains($current, '/admin/airports') ? 'active' : '' ?>"
                        href="/admin/airports">
                        <i class="bi bi-building me-1"></i>Airport
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= str_contains($current, '/admin/airline-users') ? 'active' : '' ?>"
                        href="/admin/airline-users">
                        <i class="bi bi-people me-1"></i>Airline Users
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= str_contains($current, '/admin/flight-routes') ? 'active' : '' ?>"
                        href="/admin/flight-routes">
                        <i class="bi bi-signpost-2 me-1"></i>Flight Routes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= str_contains($current, '/admin/flight-schedules') ? 'active' : '' ?>"
                        href="/admin/flight-schedules">
                        <i class="bi bi-calendar-event me-1"></i>Flight Schedules
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= str_contains($current, '/admin/users') ? 'active' : '' ?>"
                        href="/admin/users">
                        <i class="bi bi-people me-1"></i>Users
                    </a>
                </li>
            </ul>

            <!-- Profile Dropdown -->
            <div class="dropdown">
                <a class="btn btn-outline-light dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle me-1"></i>Profile
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>My Profile</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <!-- Import Data trigger -->
                    <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="bi bi-upload me-2"></i>Import Data
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</nav>
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="/admin/import" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="import_table" class="form-label">Select Table</label>
                            <select class="form-select" id="import_table" name="table" required>
                                <option value="">-- Select Table --</option>
                                <option value="aircraft">Aircraft</option>
                                <option value="airline">Airline</option>
                                <option value="airport">Airport</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="import_csv" class="form-label">CSV File</label>
                            <input type="file" class="form-control" id="import_csv" name="csv_file" accept=".csv"
                                required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>