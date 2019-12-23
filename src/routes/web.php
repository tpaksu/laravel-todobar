<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'laravel-todobar'], function () {
    Route::resource('projects', TPaksu\TodoBar\Controllers\TodoBarProjects::class);
    Route::resource('projects.items', TPaksu\TodoBar\Controllers\TodoBarItems::class);
});
