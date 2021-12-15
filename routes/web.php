<?php

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

Auth::routes(['register' => false]);

Route::get('/', 'HomeController@index')->name('home');
Route::post('/cari', 'HomeController@cari');
Route::post('/pesan/{id}', 'HomeController@kirimPesan');
Route::get('/kirim-notifikasi', 'NotificationController@index');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/initial/data', 'HomeController@initialData');
    Route::post('/', 'HomeController@getData');
    Route::post('/notifikasi', 'HomeController@getDataNotifikasi');
    Route::post('/permohonan-via-pos', 'RegisterController@viaPos');
    
    Route::post('/upload', 'RegisterController@upload');
    Route::put('/proses/{tipe}/{id}', 'RegisterController@proses');
    Route::put('/update/{id}', 'RegisterController@update');
    Route::get('/delete/{id}', 'RegisterController@destroy');
    
    Route::get('/ubah/kata/sandi', 'PasswordController@index');
    Route::post('/ubah/kata/sandi', 'PasswordController@store');

    Route::group(['prefix' => 'laporan'], function () {
         /* list notifikasi */
        Route::group(['prefix' => 'list-notifikasi'], function () {
            Route::get('/', 'Laporan\ListNotifikasiController@index');
            Route::post('/', 'Laporan\ListNotifikasiController@store');
        });

        /* laporan pencarian */
        Route::group(['prefix' => 'laporan-pencarian'], function () {
            Route::get('/', 'Laporan\LaporanPencarianController@index');
            Route::post('/', 'Laporan\LaporanPencarianController@getData');
        });

        /* monitoring scan dokumen */
        Route::group(['prefix' => 'monitoring-scan-dokumen'], function () {
            Route::get('/', 'Laporan\MonitoringScanDokumenController@index');
            Route::post('/', 'Laporan\MonitoringScanDokumenController@getData');
            Route::delete('/{id}', 'Laporan\MonitoringScanDokumenController@destroy');
        });

        /* laporan durasi pelayanan */
        Route::group(['prefix' => 'laporan-durasi-pelayanan'], function () {
            Route::get('/', 'Laporan\LaporanDurasiPelayananController@index');
            Route::post('/', 'Laporan\LaporanDurasiPelayananController@getData');
        });
    });

    /* catatan pemohon */
    Route::group(['prefix' => 'messages'], function () {
        Route::get('/{id?}', 'MessagesController@index');
        Route::post('/data', 'MessagesController@getData');
        Route::post('/{id}', 'MessagesController@store');
        Route::put('/{id}', 'MessagesController@update');
        Route::get('/get/{id}', 'MessagesController@getMessages');
    });
});


/* data-master */
Route::group(['prefix' => 'data-master'], function () {
    if (env('MULTI_KPP')) {
        /* kantor cabang */
        Route::group(['prefix' => 'company','middleware' => 'check.role.menu:COMP'], function () {
            Route::get('/', 'DataMaster\CompanyController@index');
            Route::post('/', 'DataMaster\CompanyController@store');
            Route::post('/data', 'DataMaster\CompanyController@getData');
            Route::get('/{id}', 'DataMaster\CompanyController@show');
            Route::put('/{id}', 'DataMaster\CompanyController@update');
            Route::delete('/{id}', 'DataMaster\CompanyController@destroy');
        });
    }

    /* kantor bpn */
    Route::group(['prefix' => 'company-bpn','middleware' => 'check.role.menu:COMP'], function () {
        Route::get('/', 'DataMaster\CompanyBpnController@index');
        Route::post('/', 'DataMaster\CompanyBpnController@store');
        Route::post('/data', 'DataMaster\CompanyBpnController@getData');
        Route::get('/{id}', 'DataMaster\CompanyBpnController@show');
        Route::put('/{id}', 'DataMaster\CompanyBpnController@update');
        Route::delete('/{id}', 'DataMaster\CompanyBpnController@destroy');
    });

    /* user */
    Route::group(['prefix' => 'user','middleware' => 'check.role.menu:USER'], function () {
        Route::get('/', 'DataMaster\UserController@index');
        Route::post('/', 'DataMaster\UserController@store');
        Route::post('/data', 'DataMaster\UserController@getData');
        Route::get('/{id}', 'DataMaster\UserController@show');
        Route::put('/{id}', 'DataMaster\UserController@update');
        Route::delete('/{id}', 'DataMaster\UserController@destroy');
        Route::post('/password', 'DataMaster\UserController@changePassword');

        Route::group(['prefix' => 'profil'], function () {
            Route::get('/{id}', 'DataMaster\UserController@profil');
            Route::put('/image/{id}', 'DataMaster\UserController@changeImage');
        });
    });

    /* user */
    Route::group(['prefix' => 'user-bpn','middleware' => 'check.role.menu:USER'], function () {
        Route::get('/', 'DataMaster\UserBpnController@index');
        Route::post('/', 'DataMaster\UserBpnController@store');
        Route::post('/data', 'DataMaster\UserBpnController@getData');
        Route::get('/{id}', 'DataMaster\UserBpnController@show');
        Route::put('/{id}', 'DataMaster\UserBpnController@update');
        Route::delete('/{id}', 'DataMaster\UserBpnController@destroy');
        Route::post('/password', 'DataMaster\UserBpnController@changePassword');

        Route::group(['prefix' => 'profil'], function () {
            Route::get('/{id}', 'DataMaster\UserBpnController@profil');
            Route::put('/image/{id}', 'DataMaster\UserBpnController@changeImage');
        });
    });
    
    /* jenis-register */
    Route::group(['prefix' => 'jenis-register','middleware' => 'check.role.menu:JREG'], function () {
        Route::get('/{id?}', 'DataMaster\JenisRegisterController@index');
        Route::post('/', 'DataMaster\JenisRegisterController@store');
        Route::post('/data', 'DataMaster\JenisRegisterController@getData');
        Route::put('/{id}', 'DataMaster\JenisRegisterController@update');
        Route::delete('/{id}', 'DataMaster\JenisRegisterController@destroy');

        Route::group(['prefix' => 'company'], function () {
            Route::post('/{id?}', 'DataMaster\JenisRegisterCompanyController@getData');
            Route::put('/{id}', 'DataMaster\JenisRegisterCompanyController@update');
        });
    });
});
