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

Route::get('/admin_home', "MatchController@adm_home")->name("adm_home");

Route::get('/admin_aboutus', "MatchController@adm_aboutus")->name("adm_aboutus");

Route::get('/search_match','MatchController@search_match')->name("search_match");

Route::get('/find_countries','MatchController@find_countries')->name("find_countries");

Route::get('/find_leagues','MatchController@find_leagues')->name("find_leagues");

Route::get('/find_teams','MatchController@find_teams')->name("find_teams");

Route::get('/admin_add','MatchController@adm_add')->name("adm_add");

// ajax dotaz
Route::get('/search_match','MatchController@search_match')->name("search_match");

// filtr dotaz
Route::get('/search_match_filter','MatchController@search_match_filter')->name("search_match_filter");


Route::post("/log_check", 'mainControl@check_login');

Route::post("/reg_check", 'mainControl@check_reg');

Route::post("/update_values", 'mainControl@update_other');

Route::post("/update_match", 'mainControl@update_match');

Route::post("/new_match", 'mainControl@new_match');

Route::post("/new_team", 'mainControl@new_team');

Route::post("/new_league", 'mainControl@new_league');

Route::post("/update_league", "mainControl@update_league");

Route::post("/logout", "mainControl@logout");

//Route::get('/{sport}/{league}',"App\Http\Controllers\MatchController@league");
