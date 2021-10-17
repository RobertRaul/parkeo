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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::view('tipocomprobante', 'templates.tipocomprobante');
Route::view('series', 'templates.series');
Route::view('tipos', 'templates.tipos');
Route::view('tarifas', 'templates.tarifas');
Route::view('cajones', 'templates.cajones');
Route::view('tipodocumento', 'templates.tipodocumento');
Route::view('empleados', 'templates.empleados');
