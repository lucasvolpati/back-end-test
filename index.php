<?php
ob_start();

require __DIR__ . '/vendor/autoload.php';

use CoffeeCode\Router\Router;

/**
 * Loading .env file
 */
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$router = new Router(env('APP_URL'));

$router->namespace('Source\Controllers');

/**
* Web Routes
*/
$router->get('/', 'Web:index');

/**
* API Routes
*/ 
$router->get('/api/cep/{cep}/{save}','Api:getAddress');

/*
* AJAX 
*/
$router->post("/ajax", "Web:ajax");


$router->dispatch();

ob_end_flush();
