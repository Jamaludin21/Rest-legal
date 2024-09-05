<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->group('user', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('/', 'UserController::index');
    $routes->get('(:num)', 'UserController::show/$1');
    $routes->post('register', 'UserController::register');
    $routes->post('login', 'UserController::login');
    $routes->put('update/(:num)', 'UserController::update/$1');
    $routes->delete('delete/(:num)', 'UserController::delete/$1');
});

$routes->post('payment/charge', 'PaymentController::charge');
$routes->post('payment/notification', 'PaymentController::notification');