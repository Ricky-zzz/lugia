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

// Airline User Dashboard
$router->get('/airline/dashboard', [AirlineUserController::class, 'dashboard']);

// Flights (Airline user)
// $router->get('/airline/flights', [FlightController::class, 'index']);
// $router->post('/airline/flights/store', [FlightController::class, 'store']);
// $router->post('/airline/flights/update', [FlightController::class, 'update']);
// $router->post('/airline/flights/delete', [FlightController::class, 'destroy']);

// // Routes (Airline user)
// $router->get('/airline/routes', [RouteController::class, 'index']);
// $router->post('/airline/routes/store', [RouteController::class, 'store']);
// $router->post('/airline/routes/update', [RouteController::class, 'update']);
// $router->post('/airline/routes/delete', [RouteController::class, 'destroy']);

// Public User
$router->get('/user/home', [UserController::class, 'home']);
$router->get('/flights', [UserController::class, 'flights']);
$router->get('/routes', [UserController::class, 'routes']);

$router->resolve();
