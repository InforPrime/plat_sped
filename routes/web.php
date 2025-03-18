<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    
    dd(User::where('role', 'contador')->pluck('name', 'id')->toArray());
    
    return view('welcome');
});
