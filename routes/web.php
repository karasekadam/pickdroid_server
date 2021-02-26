<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',"App\Http\Controllers\MatchController@home");

Route::get('/login', "App\Http\Controllers\MatchController@login");

Route::get('/blog', "App\Http\Controllers\MatchController@blog");

Route::get('/aboutus', "App\Http\Controllers\MatchController@aboutus");

Route::get('/welcome',"App\Http\Controllers\MatchController@welcome");

//Route::get('ajax-autocomplete-search', "App\Http\Controllers\MatchController@search");

Route::post("/log_check", 'mainControl@check_login');

Route::post("/reg_check", 'mainControl@check_reg');
//Route::get('/{sport}/{league}',"App\Http\Controllers\MatchController@league");
//cscsscs
