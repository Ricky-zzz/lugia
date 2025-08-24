<?php
// Detect current path (e.g. "/admin/airlines")
$current = $_SERVER['REQUEST_URI'];
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand fw-bold" href="/airline/dashboard">Lugia</a>

        <!-- Toggler for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link <?= str_contains($current, '/airline/flight-routes') ? 'active' : '' ?>" href="/airline/flight-routes">
                        <i class="bi bi-signpost-2 me-1"></i>Flight Routes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= str_contains($current, '/airline/flight-schedules') ? 'active' : '' ?>" href="/airline/flight-schedules">
                        <i class="bi bi-calendar-event me-1"></i>Flight Schedules
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
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
