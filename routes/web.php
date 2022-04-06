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
    return view('auth/login');
});



Route::post('preescolar/alimentacion/valor','AlimentacionController@valor');

Route::post('preescolar/profesor/activar','PersonaController@activar');

Route::post('preescolar/profesor/desactivar','PersonaController@desactivar');

Route::post('preescolar/alumno/activar','PersonaaController@activar');

Route::post('preescolar/alumno/desactivar','PersonaaController@desactivar');

Route::get('preescolar/profesor/reporte','PersonaController@reporte');

Route::get('preescolar/alumno/reporte','PersonaaController@reporte');

Route::get('preescolar/curso/reporte','CursoController@reporte');

Route::get('preescolar/compras/reporte','ComprasController@reporte');

Route::get('preescolar/ingreso/reporte','IngresoController@reporte');

Route::get('preescolar/egreso/reporte','EgresoController@reporte');


Route::post('preescolar/reportegeneral/filtro','ReportegeneralController@filtro');


Route::get('preescolar/reportegeneral/reporte/{id}','ReportegeneralController@reporte');


Route::resource('preescolar/reportegeneral','ReportegeneralController');

Route::resource('preescolar/curso','CursoController');

Route::resource('preescolar/profesor','PersonaController');

Route::resource('preescolar/alumno','PersonaaController');

Route::resource('preescolar/compras','ComprasController');

Route::resource('preescolar/egreso','EgresoController');

Route::post('preescolar/egreso/nuevo','EgresoController@nuevo');

Route::resource('preescolar/alimentacion','AlimentacionController');



Route::post('preescolar/alimentacion/cambiar','AlimentacionController@cambiar');

Route::post('preescolar/alimentacion/crearmenu','AlimentacionController@crearmenu');

Route::resource('preescolar/ingreso','IngresoController');

Route::post('preescolar/ingreso/nuevo','IngresoController@nuevo');

Route::get('preescolar/adicional/reporte','AdicionalController@reporte');


Route::resource('preescolar/adicional','AdicionalController');

Route::DELETE('eliminar/{id}','AdicionalController@changeStatus')->name('changeStatus');

Route::post('preescolar/adicional/cambiar','AdicionalController@cambiar');








Route::resource('preescolar/asignar','AsignarController');

Route::post('preescolar/asignar/cambiar','AsignarController@cambiar');

Route::post('preescolar/asignar/valor','AsignarController@valor');

Route::post('preescolar/asignar/nuevo','AsignarController@nuevo');

Route::post('preescolar/compras/nuevo','ComprasController@nuevo');

Route::get('/logout',['as'=>'logout','uses'=>'Auth\LoginController@logout']);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('preescolar/email/enviar','EmailController@index');

Route::post('preescolar/email/correo','EmailController@envio');
