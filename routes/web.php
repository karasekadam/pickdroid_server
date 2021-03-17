<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\mainControl;

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

// pls nech tam ty celý cesty, bez nich mi to nefunguje

Route::get('/',"App\Http\Controllers\MatchController@home")->name("home");

Route::get('/login', "App\Http\Controllers\MatchController@login")->name("login");

Route::get('/blog', "App\Http\Controllers\MatchController@blog")->name("blog");

Route::get('/aboutus', "App\Http\Controllers\MatchController@aboutus");

Route::get('/admin_blog', "App\Http\Controllers\MatchController@adm_blog")->name("adm_blog");

Route::get('/admin_matches', "App\Http\Controllers\MatchController@adm_matches")->name("adm_matches");

//Route::get('ajax-autocomplete-search', "App\Http\Controllers\MatchController@search");

Route::post("/log_check", 'App\Http\Controllers\mainControl@check_login');

Route::post("/reg_check", 'App\Http\Controllers\mainControl@check_reg');

Route::post("/update_values", 'App\Http\Controllers\mainControl@update_other');

Route::post("/update_match", 'App\Http\Controllers\mainControl@update_match');

//Route::get('/{sport}/{league}',"App\Http\Controllers\MatchController@league");
