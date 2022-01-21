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


//proteccion de las rutas, para que solo usuarios autenticados tengan acceso
Route::middleware(['auth'])->group(function () {

    Route::get('/home', 'DashboardController@data')->name('home');
   // Route::get('dashboard','DashboardController@data');

    Route::view('tipocomprobante', 'templates.tipocomprobante')->middleware('permission:comprobantes_acceso');
    Route::view('series', 'templates.series')->middleware('permission:series_acceso');
    Route::view('tipos', 'templates.tipos')->middleware('permission:vehiculos_acceso');
    Route::view('tarifas', 'templates.tarifas')->middleware('permission:tarifas_acceso');
    Route::view('cajones', 'templates.cajones')->middleware('permission:cajones_acceso');
    Route::view('tipodocumento', 'templates.tipodocumento')->middleware('permission:documentos_acceso');
    Route::view('empleados', 'templates.empleados')->middleware('permission:empleados_acceso');
    Route::view('usuarios', 'templates.usuarios')->middleware('permission:usuarios_acceso');
    Route::view('permisos', 'templates.permisos')->middleware('permission:permisos_acceso');
    Route::view('cajas', 'templates.cajas')->middleware('permission:cajas_acceso');
    Route::view('clientes', 'templates.clientes')->middleware('permission:clientes_acceso');
    Route::view('rentas', 'templates.rentas')->middleware('permission:rentas_acceso');
    Route::view('egresos', 'templates.egresos')->middleware('permission:egresos_acceso');
    Route::view('empresa', 'templates.empresa');

    //reportes PDF
    Route::get('reportes/caja/{idcaja}', 'Reportes\ReportCaja@Reporte_Caja')->name('caja_pdf');
    Route::get('reportes/tipovehiculo/', 'Reportes\ReportTipoVehiculos@reporte_pdf')->name('tpvehiculo_pdf');
    Route::get('reportes/tipocomprobante/', 'Reportes\ReportTipoComprobante@reporte_pdf')->name('tpcomprobante_pdf');
    Route::get('reportes/tipodocumento/', 'Reportes\ReportTipoDocumento@reporte_pdf')->name('tpdocumento_pdf');
    Route::get('reportes/tarifas/', 'Reportes\ReportTarifa@reporte_pdf')->name('tarifas_pdf');
    Route::get('reportes/cajones/', 'Reportes\ReportCajon@reporte_pdf')->name('cajones_pdf');
    Route::get('reportes/empleados/', 'Reportes\ReportEmpleados@reporte_pdf')->name('empleados_pdf');
    Route::get('reportes/clientes/', 'Reportes\ReportClientes@reporte_pdf')->name('clientes_pdf');
    Route::get('reportes/series/', 'Reportes\ReportSeries@reporte_pdf')->name('series_pdf');
    Route::get('reportes/usuarios/', 'Reportes\ReportUsuarios@reporte_pdf')->name('usuarios_pdf');

    //Rutas Imprimir Tickets
    Route::get('print/ticket/{id}','TicketController@TicketRenta');
});
