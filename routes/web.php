<?php

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/connexion',['uses'=>'UserController@getLogin','as'=>'login']);
Route::post('/connexion',['uses'=>'UserController@postLogin','as'=>'login']);

Route::get('/sinscrire',['uses'=>'UserController@getRegister','as'=>'register']);
Route::post('/sinscrire',['uses'=>'UserController@postRegister','as'=>'register']);

Route::get('/validation/{code}',['uses'=>'UserController@validation','as'=>'valider']);

Route::get('/changepswd',['uses'=>'UserController@getChange','as'=>'changepswd']);
Route::post('/changepswd',['uses'=>'UserController@postChange','as'=>'changepswd']);

Route::get('/deconnexion',['uses'=>'UserController@deconnexion','as'=>'deconnexion']);
