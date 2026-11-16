<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'AuthController::login');
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attempt');
$routes->post('logout', 'AuthController::logout');

$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('dashboard', 'SiakadController::dashboard');
    $routes->get('password', 'SiakadController::password');
    $routes->post('password', 'SiakadController::updatePassword');

    $routes->group('admin', ['filter' => 'role:admin'], static function ($routes) {
        $routes->get('/', 'SiakadController::adminDashboard');
        foreach (['mahasiswa', 'dosen', 'matakuliah'] as $resource) {
            $routes->get($resource, 'SiakadController::resource/'.$resource, ['as' => 'admin_'.$resource]);
            $routes->get($resource.'/new', 'SiakadController::resourceForm/'.$resource);
            $routes->post($resource, 'SiakadController::resourceCreate/'.$resource);
            $routes->get($resource.'/(:num)/edit', 'SiakadController::resourceEdit/$1/'.$resource);
            $routes->post($resource.'/(:num)', 'SiakadController::resourceUpdate/$1/'.$resource);
            $routes->post($resource.'/(:num)/delete', 'SiakadController::resourceDelete/$1/'.$resource);
        }
        $routes->post('akun/(:segment)/(:num)/reset', 'SiakadController::resetAccount/$1/$2');
    });

    $routes->group('mahasiswa', ['filter' => 'role:mahasiswa'], static function ($routes) {
        $routes->get('/', 'SiakadController::studentDashboard');
        $routes->get('krs', 'SiakadController::krs');
        $routes->post('krs', 'SiakadController::takeCourse');
        $routes->post('krs/(:num)/delete', 'SiakadController::dropCourse/$1');
        $routes->get('khs', 'SiakadController::khs');
        $routes->get('transkrip', 'SiakadController::transcript');
        $routes->get('transkrip/cetak', 'SiakadController::printTranscript');
        $routes->get('krs/cetak', 'SiakadController::printKrs');
    });

    $routes->group('dosen', ['filter' => 'role:dosen'], static function ($routes) {
        $routes->get('/', 'SiakadController::lecturerDashboard');
        $routes->get('perwalian', 'SiakadController::advisees');
        $routes->get('nilai', 'SiakadController::lecturerCourses');
        $routes->get('nilai/(:num)', 'SiakadController::gradeForm/$1');
        $routes->post('nilai/(:num)', 'SiakadController::saveGrades/$1');
    });
});
