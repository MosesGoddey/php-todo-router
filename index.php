<?php
session_start();
require_once 'config/database.php';
require_once 'router.php';

// Initialize router
$router = new Router();

// Authentication routes
$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@authenticate');
$router->get('/register', 'AuthController@showRegister');
$router->post('/register', 'AuthController@register');
$router->get('/logout', 'AuthController@logout');

// Todo routes
$router->get('/', 'TodoController@index');
$router->get('/todos', 'TodoController@index');
$router->get('/todos/create', 'TodoController@create');
$router->post('/todos/store', 'TodoController@store');
$router->get('/todos/edit/{id}', 'TodoController@edit');
$router->post('/todos/update/{id}', 'TodoController@update');
$router->get('/todos/delete/{id}', 'TodoController@delete');
$router->get('/todos/complete/{id}', 'TodoController@toggleComplete');


// Admin routes
$router->get('/admin', 'AdminController@dashboard');
$router->get('/admin/users', 'AdminController@users');
$router->get('/admin/stats', 'AdminController@stats');

// Dispatch route
$router->dispatch();
?>