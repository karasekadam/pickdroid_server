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

Route::get('/',"MatchController@home")->name("home");

Route::get('/login', "MatchController@login")->name("login");

Route::get('/blog', "MatchController@blog")->name("blog");

Route::get('/aboutus', "MatchController@aboutus");

Route::get('/admin_blog', "MatchController@adm_blog")->name("adm_blog");

Route::get('/admin_matches', "MatchController@adm_matches")->name("adm_matches");

//Route::get('ajax-autocomplete-search', "App\Http\Controllers\MatchController@search");

Route::post("/log_check", 'mainControl@check_login');

Route::post("/reg_check", 'mainControl@check_reg');

Route::post("/update_values", 'mainControl@update_other');

Route::post("/update_match", 'mainControl@update_match');

//Route::get('/{sport}/{league}',"App\Http\Controllers\MatchController@league");