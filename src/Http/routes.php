<?php

use Asundust\DcatConfig\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('configs/refresh', Controllers\DcatConfigController::class . '@refresh');
Route::resource('configs', Controllers\DcatConfigController::class);