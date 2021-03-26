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

Route::get('/',"App\Http\Controllers\MatchController@home")->name("home");

Route::get('/login', "App\Http\Controllers\MatchController@login")->name("login");

Route::get('/blog', "App\Http\Controllers\MatchController@blog")->name("blog");

Route::get('/aboutus', "App\Http\Controllers\MatchController@aboutus");

Route::get('/admin_blog', "App\Http\Controllers\MatchController@adm_blog")->name("adm_blog");

Route::get('/admin_home', "App\Http\Controllers\MatchController@adm_home")->name("adm_home");

// dočasná stránka pro testování vyhledávání - už možná není potřeba
// Route::get("/search", 'App\Http\Controllers\MatchController@search')->name("search");

// ajax dotaz na vyhledávání
Route::get('/search_match','App\Http\Controllers\MatchController@search_match')->name("search_match");


Route::post("/log_check", 'App\Http\Controllers\mainControl@check_login');

Route::post("/reg_check", 'App\Http\Controllers\mainControl@check_reg');

Route::post("/update_values", 'App\Http\Controllers\mainControl@update_other');

Route::post("/update_match", 'App\Http\Controllers\mainControl@update_match');

Route::post("/new_match", 'App\Http\Controllers\mainControl@new_match');


