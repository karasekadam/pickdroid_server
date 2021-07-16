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

header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

Route::get('/',"MatchController@home")->name("home");

Route::get('/succ', function () {
    return view('success_reg');
});

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

Route::get('/admin_add_country','MatchController@adm_add_country')->name("adm_add_country");

Route::get('/admin_logo','MatchController@adm_logo')->name("adm_logo");

Route::get('/admin_fill', 'MatchController@adm_fill')->name("adm_fill");

Route::get('/google_login', 'mainControl@google_login');

Route::get('/after_login', 'mainControl@after_login');

Route::get('/account', 'mainControl@account');

// ajax dotaz
Route::get('/search_match','MatchController@search_match')->name("search_match");

// filtr dotaz
Route::get('/search_match_filter','MatchController@search_match_filter')->name("search_match_filter");


Route::post("/log_check", 'mainControl@check_login');

Route::post("/reg_check", 'mainControl@check_reg');

Route::post("/update_values", 'mainControl@update_other');

Route::post("/update_match", 'mainControl@update_match');

Route::post("/update_lock", 'mainControl@update_lock');

Route::post("/new_match", 'mainControl@new_match');

Route::post("/new_team", 'mainControl@new_team')->name("new_team");

Route::post("/new_league", 'mainControl@new_league')->name("new_league");

Route::post("/new_country", 'mainControl@new_country')->name("new_country");

Route::post("/upload_logo", 'mainControl@upload_logo')->name("upload_logo");

Route::post("/update_league", "mainControl@update_league");

Route::post("/country_fill", "mainControl@country_fill");

Route::post("/logout", "mainControl@logout");

// cors error handler píčovina
Route::middleware(['cors'])->group(function () {
    Route::post('/hogehoge', 'Controller@hogehoge');
});
