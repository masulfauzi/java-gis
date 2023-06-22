<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Provinsi\Controllers\ProvinsiController;

Route::controller(ProvinsiController::class)->middleware(['web','auth'])->name('provinsi.')->group(function(){
	Route::get('/provinsi', 'index')->name('index');
	Route::get('/provinsi/data', 'data')->name('data.index');
	Route::get('/provinsi/create', 'create')->name('create');
	Route::post('/provinsi', 'store')->name('store');
	Route::get('/provinsi/{provinsi}', 'show')->name('show');
	Route::get('/provinsi/{provinsi}/edit', 'edit')->name('edit');
	Route::patch('/provinsi/{provinsi}', 'update')->name('update');
	Route::get('/provinsi/{provinsi}/delete', 'destroy')->name('destroy');
});