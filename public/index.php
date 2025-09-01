<?php
session_start();
spl_autoload_register(function($class) {
    foreach (['app/controllers/', 'app/models/', 'app/core/'] as $dir) {
        $file = __DIR__ . "/../$dir$class.php";
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
});

$config = require __DIR__ . "/../config/config.php";
$db = Database::getInstance($config['db']);

$router = new Router();

// Authentication
$router->get('/', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'doLogin']);
$router->get('/logout', [AuthController::class, 'logout']);
$router->get('/register', [AuthController::class, 'register']);
$router->post('/doRegister', [AuthController::class, 'doRegister']);

// Admin Dashboard
$router->get('/admin/dashboard', [AdminController::class, 'dashboard']);

// Airline routes (Admin)
$router->get('/admin/airlines', [AirlineController::class, 'index']);
$router->post('/admin/airlines/store', [AirlineController::class, 'store']);
$router->post('/admin/airlines/update', [AirlineController::class, 'update']);
$router->post('/admin/airlines/delete', [AirlineController::class, 'destroy']);

// Aircraft routes (Admin)
$router->get('/admin/aircraft', [AircraftController::class, 'index']);
$router->post('/admin/aircraft/store', [AircraftController::class, 'store']);
$router->post('/admin/aircraft/update', [AircraftController::class, 'update']);
$router->post('/admin/aircraft/delete', [AircraftController::class, 'destroy']);

// User routes (Admin)
$router->get('/admin/users', [UserController::class, 'index']);
$router->post('/admin/users/store', [UserController::class, 'store']);
$router->post('/admin/users/update', [UserController::class, 'update']);
$router->post('/admin/users/delete', [UserController::class, 'destroy']);


// Airport routes (Admin)
$router->get('/admin/airports', [AirportController::class, 'index']);
$router->post('/admin/airports/store', [AirportController::class, 'store']);
$router->post('/admin/airports/update', [AirportController::class, 'update']);
$router->post('/admin/airports/delete', [AirportController::class, 'destroy']);

// Airline Users (Admin)
$router->get('/admin/airline-users', [AirlineUserController::class, 'index']);
$router->post('/admin/airline-users/store', [AirlineUserController::class, 'store']);
$router->post('/admin/airline-users/update', [AirlineUserController::class, 'update']);
$router->post('/admin/airline-users/delete', [AirlineUserController::class, 'destroy']);

// Flight Routes (Admin)
$router->get('/admin/flight-routes', [FlightRouteController::class, 'index']);
$router->post('/admin/flight-routes/store', [FlightRouteController::class, 'store']);
$router->post('/admin/flight-routes/update', [FlightRouteController::class, 'update']);
$router->post('/admin/flight-routes/delete', [FlightRouteController::class, 'destroy']);

// Flight Schedules (Admin)
$router->get('/admin/flight-schedules', [FlightScheduleController::class, 'index']);
$router->post('/admin/flight-schedules/store', [FlightScheduleController::class, 'store']);
$router->post('/admin/flight-schedules/update', [FlightScheduleController::class, 'update']);
$router->post('/admin/flight-schedules/delete', [FlightScheduleController::class, 'destroy']);

// Airline User Dashboard
$router->get('/airline/dashboard', [AirlineUserController::class, 'dashboard']);

// Flight Routes (Airline User)
$router->get('/airline/flight-routes', [AirlineFlightRouteController::class, 'index']);
$router->post('/airline/flight-routes/store', [AirlineFlightRouteController::class, 'store']);
$router->post('/airline/flight-routes/update', [AirlineFlightRouteController::class, 'update']);
$router->post('/airline/flight-routes/delete', [AirlineFlightRouteController::class, 'destroy']);

// Flight Schedules (Airline User)
$router->get('/airline/flight-schedules', [AFScheduleController::class, 'index']);
$router->post('/airline/flight-schedules/store', [AFScheduleController::class, 'store']);
$router->post('/airline/flight-schedules/update', [AFScheduleController::class, 'update']);
$router->post('/airline/flight-schedules/delete', [AFScheduleController::class, 'destroy']);

// Public User
$router->get('/user/dashboard', [UserController::class, 'dashboard']);
$router->get('/user/flight-routes', [UserFlightRouteController::class, 'index']);
$router->get('/user/flight-schedules', [UFScheduleController::class, 'index']);

$router->post('/admin/import', [ImportController::class, 'import']);


$router->resolve();
