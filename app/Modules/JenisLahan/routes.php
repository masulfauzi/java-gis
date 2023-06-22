<?php

use Illuminate\Support\Facades\Route;
use App\Modules\JenisLahan\Controllers\JenisLahanController;

Route::controller(JenisLahanController::class)->middleware(['web','auth'])->name('jenislahan.')->group(function(){
	Route::get('/jenislahan', 'index')->name('index');
	Route::get('/jenislahan/data', 'data')->name('data.index');
	Route::get('/jenislahan/create', 'create')->name('create');
	Route::post('/jenislahan', 'store')->name('store');
	Route::get('/jenislahan/{jenislahan}', 'show')->name('show');
	Route::get('/jenislahan/{jenislahan}/edit', 'edit')->name('edit');
	Route::patch('/jenislahan/{jenislahan}', 'update')->name('update');
	Route::get('/jenislahan/{jenislahan}/delete', 'destroy')->name('destroy');
});