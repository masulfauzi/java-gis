<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Desa\Controllers\DesaController;

Route::controller(DesaController::class)->middleware(['web','auth'])->name('desa.')->group(function(){
	Route::get('/desa', 'index')->name('index');
	Route::get('/desa/data', 'data')->name('data.index');
	Route::get('/desa/create', 'create')->name('create');
	Route::post('/desa', 'store')->name('store');
	Route::get('/desa/{desa}', 'show')->name('show');
	Route::get('/desa/{desa}/edit', 'edit')->name('edit');
	Route::patch('/desa/{desa}', 'update')->name('update');
	Route::get('/desa/{desa}/delete', 'destroy')->name('destroy');
});