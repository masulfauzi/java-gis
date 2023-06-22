<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Kecamatan\Controllers\KecamatanController;

Route::controller(KecamatanController::class)->middleware(['web','auth'])->name('kecamatan.')->group(function(){
	Route::get('/kecamatan', 'index')->name('index');
	Route::get('/kecamatan/data', 'data')->name('data.index');
	Route::get('/kecamatan/create', 'create')->name('create');
	Route::post('/kecamatan', 'store')->name('store');
	Route::get('/kecamatan/{kecamatan}', 'show')->name('show');
	Route::get('/kecamatan/{kecamatan}/edit', 'edit')->name('edit');
	Route::patch('/kecamatan/{kecamatan}', 'update')->name('update');
	Route::get('/kecamatan/{kecamatan}/delete', 'destroy')->name('destroy');
});