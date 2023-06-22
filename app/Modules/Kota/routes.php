<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Kota\Controllers\KotaController;

Route::controller(KotaController::class)->middleware(['web','auth'])->name('kota.')->group(function(){
	Route::get('/kota', 'index')->name('index');
	Route::get('/kota/data', 'data')->name('data.index');
	Route::get('/kota/create', 'create')->name('create');
	Route::post('/kota', 'store')->name('store');
	Route::get('/kota/{kota}', 'show')->name('show');
	Route::get('/kota/{kota}/edit', 'edit')->name('edit');
	Route::patch('/kota/{kota}', 'update')->name('update');
	Route::get('/kota/{kota}/delete', 'destroy')->name('destroy');
});