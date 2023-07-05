<?php

namespace Config;

use App\Controllers\Auth\LoginController;
use App\Controllers\Auth\RegisterController;
use App\Controllers\ProductController;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

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
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// service('auth')->routes($routes);
$routes->get('/', 'Home::index');

service('auth')->routes($routes, ['except' => ['login', 'regiter']]);
// api
$routes->group('api', static function ($routes) {
    $routes->post('login', [LoginController::class, 'jwtLogin']);

    $routes->group('seller', static function ($routes) {
        $routes->post('register', [RegisterController::class, 'registerSeller'], ['filter' => 'jwtgroup-filter:admin']);
        // product
        $routes->get('product', [ProductController::class, 'index'], ['filter' => 'jwtgroup-filter:seller']);
        $routes->get('product/(:num)', [ProductController::class, 'show/$1'], ['filter' => 'jwtgroup-filter:seller']);
        $routes->post('product', [ProductController::class, 'create'], ['filter' => 'jwtgroup-filter:seller']);
        $routes->put('product/(:num)', [ProductController::class, 'update/$1'], ['filter' => 'jwtgroup-filter:seller']);
        $routes->delete('product/(:num)', [ProductController::class, 'delete/$1'], ['filter' => 'jwtgroup-filter:seller']);
        $routes->delete('product/image/(:num)', [ProductController::class, 'deleteImageProduct/$1'], ['filter' => 'jwtgroup-filter:seller']);
    });
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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
