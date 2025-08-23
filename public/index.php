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

$router->get('/', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'doLogin']);
$router->get('/admin/dashboard', [AdminController::class, 'dashboard']);

// Airline routes
$router->get('/admin/airlines', [AirlineController::class, 'index']);   // list
$router->post('/admin/airlines/store', [AirlineController::class, 'store']);  // handle form
$router->post('/admin/airlines/update', [AirlineController::class, 'update']);
$router->post('/admin/airlines/delete', [AirlineController::class, 'destroy']);

// Aircraft routes
$router->get('/admin/aircraft', [AircraftController::class, 'index']);   // list
$router->post('/admin/aircraft/store', [AircraftController::class, 'store']);  // handle form
$router->post('/admin/aircraft/update', [AircraftController::class, 'update']);
$router->post('/admin/aircraft/delete', [AircraftController::class, 'destroy']);

// Airport routes
$router->get('/admin/airports', [AirportController::class, 'index']);   // list/show form
$router->post('/admin/airports/store', [AirportController::class, 'store']);  // handle form
$router->post('/admin/airports/update', [AirportController::class, 'update']);
$router->post('/admin/airports/delete', [AirportController::class, 'destroy']);



$router->get('/airline/dashboard', [AirlineUserController::class, 'dashboard']);
$router->get('/user/home', [UserController::class, 'home']);


$router->resolve();
