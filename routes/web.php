<?php

Route::view('/', 'welcome');

Auth::routes(['verify' => true]);

Route::middleware(['auth','verified'])->group(function () {
    Route::prefix('routes')->group(function () {
        Route::get('trashed', 'RouteController@indexTrashed')->name('routes.trashed');
        Route::put('{route}/restore', 'RouteController@restore')->name('routes.restore');
        Route::delete('{route}/delete', 'RouteController@delete')->name('routes.delete');
        Route::post('{route}/copy', 'RouteController@copy')->name('routes.copy');
    });
    Route::resource('routes', 'RouteController')->except(['show', 'create']);
});

Route::get('routes/create', 'RouteController@create')->name('routes.create');
Route::post('contact', 'ContactController')->name('contact');
Route::view('privacy', 'privacy')->name('privacy');
Route::view('legal', 'legal')->name('legal');

