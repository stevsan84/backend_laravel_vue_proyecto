<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    //return view('welcome');
    return ":)"; //bloqueaar el acceso al bakend
});
