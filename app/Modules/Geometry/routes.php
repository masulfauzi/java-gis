<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Geometry\Controllers\GeometryController;

Route::controller(GeometryController::class)->middleware(['web','auth'])->name('geometry.')->group(function(){
	Route::get('/geometry', 'index')->name('index');
	Route::get('/geometry/data', 'data')->name('data.index');
	Route::get('/geometry/create', 'create')->name('create');
	Route::post('/geometry', 'store')->name('store');
	Route::get('/geometry/{geometry}', 'show')->name('show');
	Route::get('/geometry/{geometry}/edit', 'edit')->name('edit');
	Route::patch('/geometry/{geometry}', 'update')->name('update');
	Route::get('/geometry/{geometry}/delete', 'destroy')->name('destroy');
});