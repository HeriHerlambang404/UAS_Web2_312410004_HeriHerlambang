<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

$routes->get('/artikel', 'Artikel::index');
$routes->get('/artikel/(:any)', 'Artikel::view/$1');

$routes->match(['get', 'post'], '/user/login', 'User::login');
$routes->get('/user/logout', 'User::logout');

$routes->get('/ajax', 'AjaxController::index');
$routes->get('/ajax/getData', 'AjaxController::getData');
$routes->delete('/ajax/delete/(:num)', 'AjaxController::delete/$1');

$routes->get('post', 'Post::index');
$routes->get('post/(:segment)', 'Post::show/$1');
$routes->post('post', 'Post::create', ['filter' => 'apiauth']);
$routes->put('post/(:segment)', 'Post::update/$1', ['filter' => 'apiauth']);
$routes->delete('post/(:segment)', 'Post::delete/$1', ['filter' => 'apiauth']);
$routes->post('api/login', 'Api\Auth::login');

$routes->get('/admin/artikel', 'Artikel::admin_index');

$routes->match(['get', 'post'],
    '/admin/artikel/add',
    'Artikel::add'
);

$routes->match(['get', 'post'],
    '/admin/artikel/edit/(:num)',
    'Artikel::edit/$1'
);

$routes->get(
    '/admin/artikel/delete/(:num)',
    'Artikel::delete/$1'
);
