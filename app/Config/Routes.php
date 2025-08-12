<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('back', function () {
    return redirect()->back();
});


$routes->get('server', 'Server::getServerTime');

$routes->get('/', 'Home::index');
$routes->get('/login', 'Auth::index');
$routes->get('/register', 'Pendaftar::register');
$routes->post('pendaftar/save', 'Pendaftar::save');

// $routes->get('/', 'Auth::index'); // Ini akan mencocokkan "/auth/"
$routes->group('auth', ['filter' => 'redirectIfAuthenticated'], function ($routes) {
    $routes->get('/', 'Auth::index');
    $routes->get('register', 'Auth::register');
    $routes->post('register', 'Auth::register');
    $routes->get('logout', 'Auth::logout', ['filter' => null]); // Mengecualikan dari filter
    $routes->post('check-auth', 'Auth::checkAuth');
});


$routes->group('admin', ['filter' => 'authenticate'], function ($routes) {
    // $routes->group("Admin", ["filter" => "auth"], function ($routes) {
    $routes->get('dashboard', 'AdminDashboard::index', ['filter' => 'authenticate']);

    // Admin
    // Admin Profile
    $routes->get('profile', 'AdminProfil::index');

    $routes->post('profile/update', 'AdminProfil::updateProfile');
    $routes->get('users', 'AdminUsers::index');
    // });
    // Jurusan
    $routes->get('kode/jurusan', 'AdminJurusan::index');
    $routes->get('kode/jurusan/add', 'AdminJurusan::add');
    $routes->post('kode/jurusan/save', 'AdminJurusan::save');
    $routes->get('kode/jurusan/edit/(:num)', 'AdminJurusan::edit/$1');
    $routes->post('kode/jurusan/update/(:num)', 'AdminJurusan::update/$1');
    $routes->get('kode/jurusan/delete/(:num)', 'AdminJurusan::delete/$1');

    // Mahasiswa
    $routes->get('cmshbaru', 'CmshBaru::cmshbaru');
    $routes->get('cmshbaru/add', 'CmshBaru::add');
    $routes->post('cmshbaru/save', 'CmshBaru::save');
    $routes->get('cmshbaru/formImport', 'CmshBaru::formImport');
    $routes->post('cmshbaru/importExcel', 'CmshBaru::importExcel');
    $routes->get('cmshbaru/edit/(:any)', 'CmshBaru::editcmshbaru/$1');
    $routes->post('cmshbaru/edit/(:any)', 'CmshBaru::editCmshBaruPost/$1');
    $routes->get('cmshbaru/delete/(:any)', 'CmshBaru::deleteKategori/$1');
    $routes->get('cmshbaru/downloadTemplate', 'DownloadController::downloadTemplate');
    $routes->get('cmshbaru/downloadTemplateCSV', 'DownloadController::downloadTemplateCSV');

    // Prodi
    $routes->get('kode/prodi', 'AdminProdi::index');
    $routes->get('kode/prodi/add', 'AdminProdi::add');
    $routes->post('kode/prodi/save', 'AdminProdi::save');
    $routes->get('kode/prodi/edit/(:num)', 'AdminProdi::edit/$1');
    $routes->post('kode/prodi/update/(:num)', 'AdminProdi::update/$1');
    $routes->get('kode/prodi/delete/(:num)', 'AdminProdi::delete/$1');

    // Tahun
    $routes->get('kode/tahun', 'AdminTahun::index');
    $routes->get('kode/tahun/add', 'AdminTahun::add');
    $routes->post('kode/tahun/save', 'AdminTahun::save');
    $routes->get('kode/tahun/edit/(:num)', 'AdminTahun::edit/$1');
    $routes->post('kode/tahun/update/(:num)', 'AdminTahun::update/$1');
    $routes->get('kode/tahun/delete/(:num)', 'AdminTahun::delete/$1');

    // Npm
    $routes->get('npm', 'AdminNpm::index');
    $routes->get('npm/add', 'AdminNpm::add');
    $routes->post('npm/save', 'AdminNpm::save');
    $routes->get('npm/edit/(:num)', 'AdminNpm::edit/$1');
    $routes->post('npm/update/(:num)', 'AdminNpm::update/$1');
    $routes->get('npm/delete/(:num)', 'AdminNpm::delete/$1');
});

$routes->group('mahasiswa', ['filter' => 'authenticate'], function ($routes) {
    // $routes->group("Admin", ["filter" => "auth"], function ($routes) {
    $routes->get('dashboard', 'MahasiswaDashboard::index', ['filter' => 'authenticate']);

    $routes->get('searchNama', 'MahasiswaDashboard::searchNama');
    $routes->post('generateNpm', 'MahasiswaDashboard::generateNpm');
    $routes->get('getMahasiswaDetail', 'MahasiswaDashboard::getMahasiswaDetail');
    // $routes->get('dashboard', 'PelangganDashboard::index');
    $routes->get('profile', 'MahasiswaProfil::index');
    $routes->post('profile/update', 'MahasiswaProfil::updateProfil');
    $routes->get('profile/export', 'MahasiswaProfil::exportNametag');
});
