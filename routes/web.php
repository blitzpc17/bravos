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



Route::get('/admin/login', function(){
    return view('Backend.sistema.login');
});


Route::group(['prefix' => 'admin'/*,  'middleware' => 'auth'*/], function ()
{
    Route::get('/', function(){
        return view('Backend.sistema.admin');
    })->name('admin.home');

    //procesos
    Route::get('procesos', 'ProcesosController@index')->name('procesos.show');
    Route::post('procesos/save', 'ProcesosController@save')->name('procesos.save');
    Route::get('procesos/listar', 'ProcesosController@ListarRegistros');
    Route::get('procesos/obtener/{id}', 'ProcesosController@ObtenerRegistro');
    Route::get('procesos/del/{id}', 'ProcesosController@EliminarRegistro');

});
