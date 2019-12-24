<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'laravel-todobar'], function () {
    Route::resource('projects', TPaksu\TodoBar\Controllers\TodoBarProjects::class);
    Route::resource('projects.tasks', TPaksu\TodoBar\Controllers\TodoBarTasks::class);
});
