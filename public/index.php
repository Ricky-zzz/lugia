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
$router->get('/admin/airlines', [AirlineController::class, 'index']);   // list // show form
$router->post('/admin/airlines/store', [AirlineController::class, 'store']);  // handle form
$router->post('/admin/airlines/update', [AirlineController::class, 'update']);
$router->post('/admin/airlines/delete', [AirlineController::class, 'destroy']);


$router->get('/airline/dashboard', [AirlineUserController::class, 'dashboard']);
$router->get('/user/home', [UserController::class, 'home']);


$router->resolve();
