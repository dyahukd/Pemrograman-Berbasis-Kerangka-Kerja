<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('/shop', 'Shop::index');
$routes->post('/cart/add/(:num)', 'Cart::add/$1');
$routes->get('/cart', 'Cart::index');
$routes->post('/cart/update/(:num)', 'Cart::update/$1');
$routes->post('/cart/remove/(:num)', 'Cart::remove/$1');
$routes->get('/checkout', 'Checkout::index');
$routes->post('/checkout/place-order', 'Checkout::placeOrder');
$routes->get('/checkout/success/(:num)', 'Checkout::success/$1');

$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::doRegister');

$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::doLogin');

$routes->get('/admin/login', 'Auth::adminLogin');
$routes->post('/admin/login', 'Auth::doAdminLogin');

$routes->post('/logout', 'Auth::logout');

$routes->group('admin', ['filter' => 'admin'], static function ($routes) {
    $routes->get('dashboard', 'Admin::dashboard');
    $routes->get('orders', 'Admin::orders');
    $routes->post('orders/update/(:num)', 'Admin::updateStatus/$1');
});

$routes->get('/my-orders', 'Orders::index');
$routes->get('/my-orders/(:num)', 'Orders::show/$1');

$routes->get('/product/(:segment)', 'Product::detail/$1');


$routes->get('admin/products', 'AdminProducts::index');
$routes->get('admin/products/new', 'AdminProducts::new');
$routes->post('admin/products/store', 'AdminProducts::store');
$routes->get('admin/products/edit/(:num)', 'AdminProducts::edit/$1');
$routes->post('admin/products/update/(:num)', 'AdminProducts::update/$1');
$routes->post('admin/products/delete/(:num)', 'AdminProducts::delete/$1');