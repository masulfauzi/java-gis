<?php

use Illuminate\Support\Facades\Route;
use App\Modules\BatasAdministrasi\Controllers\BatasAdministrasiController;

Route::controller(BatasAdministrasiController::class)->middleware(['web','auth'])->name('batasadministrasi.')->group(function(){
	Route::get('/batasadministrasi', 'index')->name('index');
	Route::get('/batasadministrasi/data', 'data')->name('data.index');
	Route::get('/batasadministrasi/create', 'create')->name('create');
	Route::post('/batasadministrasi', 'store')->name('store');
	Route::get('/batasadministrasi/{batasadministrasi}', 'show')->name('show');
	Route::get('/batasadministrasi/{batasadministrasi}/edit', 'edit')->name('edit');
	Route::patch('/batasadministrasi/{batasadministrasi}', 'update')->name('update');
	Route::get('/batasadministrasi/{batasadministrasi}/delete', 'destroy')->name('destroy');
});