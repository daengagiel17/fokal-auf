<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@home')->name('home');
Route::get('/statistik', 'HomeController@statistik')->name('statistik');

// Auth Provider
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider')->name('login.provider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('registrasi', 'Auth\RegistrasiController@showRegistrasi')->name('registrasi');
Route::post('registrasi', 'Auth\RegistrasiController@registrasi');

// ADMIN
Route::middleware(['auth'])->group(function() {
    Route::get('database', 'DatabaseController@index')->name('database.index');
    Route::get('database/{id}', 'DatabaseController@show')->name('database.show');        

    //Route yang berada dalam group ini hanya dapat diakses oleh user yang memiliki role super-admin
    Route::name('superadmin.')->namespace('Superadmin')->prefix('superadmin')->middleware(['role:super-admin'])->group(function () {
        // Admin
        Route::name('akses.')->group(function () {
            Route::resource('permission', 'PermissionController')->except([
                'create', 'show', 'edit', 'update'
            ]);

            Route::resource('role', 'RoleController')->except([
                'create', 'show', 'edit', 'update'
            ]);
            Route::get('role/{id}/permissions', 'RoleController@rolePermissions')->name('role.permissions');
            Route::put('role/{id}/permissions', 'RoleController@setPermissions')->name('role.permissions');

            Route::resource('user', 'UserController')->except([
                'show'
            ]);
            Route::get('user/{id}/roles', 'UserController@userRoles')->name('user.roles');
            Route::put('user/{id}/roles', 'UserController@setRoles')->name('user.roles');
        });

        Route::get('/setting', 'SettingController@index')->name('setting.index');
        Route::post('/setting/import-kabupaten', 'SettingController@importKabupaten')->name('setting.import-kabupaten');
        Route::post('/setting/import-anggota', 'SettingController@importAnggota')->name('setting.import-anggota');
    });

    // Admin
    Route::name('admin.')->namespace('Admin')->prefix('admin')->group(function () {
        Route::get('/', 'AdminController@index')->name('index');

        // Anggota
        Route::middleware(['role:admin'])->post('anggota/{id}/verify', 'AnggotaController@verify')->name('anggota.verify');
        Route::middleware(['role:admin'])->resource('anggota', 'AnggotaController');

        Route::middleware(['role:admin'])->resource('pekerjaan', 'PekerjaanController');
        Route::middleware(['role:admin'])->resource('organisasi', 'OrganisasiController');
    });

    // Admin
    Route::name('profil.')->namespace('Profil')->prefix('profil')->group(function () {
        Route::get('anggota', 'AnggotaController@show')->name('anggota.show');
        Route::get('anggota/create', 'AnggotaController@create')->name('anggota.create');
        Route::post('anggota', 'AnggotaController@store')->name('anggota.store');
        Route::get('anggota/edit', 'AnggotaController@edit')->name('anggota.edit');
        Route::put('anggota', 'AnggotaController@update')->name('anggota.update');

        Route::resource('pekerjaan', 'PekerjaanController');
        Route::resource('organisasi', 'OrganisasiController');
    });

});

// Auth::routes();