<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/dashboard', 'Dashboard::index');

$routes->resource('photos');

// Equivalent to the following:
$routes->get('user/new',             'users::new');
$routes->post('user',                'users::create');
$routes->get('user',                 'users::index');
$routes->get('user/(:segment)',      'users::show/$1');
$routes->get('user/(:segment)/edit', 'users::edit/$1');
$routes->put('user/(:segment)',      'users::update/$1');
$routes->patch('user/(:segment)',    'users::update/$1');
$routes->delete('user/(:segment)',   'users::delete/$1');

$routes->post('login', 'Login::login');
$routes->get('auth', 'Users::index');
$routes->get('logout', 'Users::logout');
$routes->get('forgot-password', 'Users::forgotPassword');
$routes->post('reset-password', 'Login::resetPassword');
$routes->get('change-password', 'Login::passwordChange');
$routes->post('change-password', 'Login::savePassword');

$routes->post('register', 'Login::create');

$routes->post('authpass', 'AuthController::checkUser');

$routes->group('profile', function ($routes) {
    $routes->post('image_update/(:any)','ProfileController::updateImage/$1');
    $routes->delete('image_delete/(:any)','ProfileController::deleteImage/$1');
    $routes->put('update_password/(:any)','ProfileController::update_password/$1');
    $routes->put('update_general/(:any)','ProfileController::update_general/$1');
    $routes->get('search','ProfileController::search');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
