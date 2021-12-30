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
    return view('auth.login');
});

Auth::routes();

Route::get('/inicio', 'HomeController@index')->name('home');

Route::view('tipocomprobante', 'templates.tipocomprobante');
Route::view('series', 'templates.series');
Route::view('tipos', 'templates.tipos');
Route::view('tarifas', 'templates.tarifas');
Route::view('cajones', 'templates.cajones');
Route::view('tipodocumento', 'templates.tipodocumento');
Route::view('empleados', 'templates.empleados');
Route::view('usuarios', 'templates.usuarios');
Route::view('permisos', 'templates.permisos');
Route::view('cajas', 'templates.cajas');
Route::view('clientes', 'templates.clientes');
Route::view('rentas', 'templates.rentas');
Route::view('egresos', 'templates.egresos');

//reportes PDF
Route::get('reportes/caja/{idcaja}','Reportes\ReportCaja@Reporte_Caja')->name('caja_pdf');
Route::get('reportes/tipovehiculo/','Reportes\ReportTipoVehiculos@reporte_pdf')->name('tpvehiculo_pdf');
Route::get('reportes/tipocomprobante/','Reportes\ReportTipoComprobante@reporte_pdf')->name('tpcomprobante_pdf');
Route::get('reportes/tipodocumento/','Reportes\ReportTipoDocumento@reporte_pdf')->name('tpdocumento_pdf');
Route::get('reportes/tarifas/','Reportes\ReportTarifa@reporte_pdf')->name('tarifas_pdf');
