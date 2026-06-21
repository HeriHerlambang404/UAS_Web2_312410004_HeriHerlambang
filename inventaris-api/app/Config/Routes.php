<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->group('api', ['filter' => 'mycors'], function($routes) {
    $routes->options('(:any)', function() { return ''; });
    $routes->post('register', 'API\AuthController::register');

    // Endpoint Public
    $routes->post('login', 'API\AuthController::login');
    // ... (sisa route lo di bawahnya biarkan saja)
    
    // Endpoint Public (Tanpa Token)
    $routes->post('login', 'API\AuthController::login');
    $routes->get('barang', 'API\BarangController::index'); // Public bisa lihat barang
    $routes->get('kategori', 'API\KategoriController::index'); // Public bisa lihat kategori
    $routes->get('supplier', 'API\SupplierController::index'); // Public bisa lihat supplier
    $routes->get('setup-admin', function() {
    $userModel = new \App\Models\UserModel();
    
    // Cek dulu biar nggak dobel
    if ($userModel->where('username', 'admin')->first()) {
        return "Admin sudah ada di database bro!";
    }

    // Insert admin dengan password yang di-hash dengan benar
    $userModel->insert([
        'username' => 'admin',
        'password' => password_hash('admin123', PASSWORD_DEFAULT)
    ]);
    
    return "Mantap! Akun admin berhasil dibuat. Silakan login pakai password: admin123";
});

    // Endpoint Protected (Wajib Token)
    $routes->group('', ['filter' => 'auth'], function($routes) {
        $routes->post('logout', 'API\AuthController::logout');
        
        // Route untuk nambah, update, hapus wajib login
        $routes->resource('kategori', ['controller' => 'API\KategoriController', 'only' => ['show', 'create', 'update', 'delete']]);
        $routes->resource('supplier', ['controller' => 'API\SupplierController', 'only' => ['show', 'create', 'update', 'delete']]);
        $routes->resource('barang', ['controller' => 'API\BarangController', 'only' => ['show', 'create', 'update', 'delete']]);
        
        $routes->resource('barang-masuk', ['controller' => 'API\BarangMasukController']);
        $routes->resource('barang-keluar', ['controller' => 'API\BarangKeluarController']);
    });
});