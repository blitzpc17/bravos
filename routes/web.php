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


Route::get('/login', function () {
    echo 'login perros clientes';
})->name('login');



Route::group(['prefix' => 'admin'/*,  'middleware' => 'auth'*/], function ()
{
    Route::get('login', 'AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'AdminLoginController@login')->name('admin.login.submit');
    Route::get('logout', 'AdminLoginController@logout')->name('admin.logout');
    Route::get('/', 'AdminController@index')->name('admin.dashboard');

    //procesos
    Route::get('procesos', 'ProcesosController@index')->name('procesos.show');
    Route::post('procesos/save', 'ProcesosController@save')->name('procesos.save');
    Route::get('procesos/listar', 'ProcesosController@ListarRegistros');
    Route::get('procesos/obtener/{id}', 'ProcesosController@ObtenerRegistro');
    Route::get('procesos/del/{id}', 'ProcesosController@EliminarRegistro');

    Route::get('procesos/cbx/listar', 'ProcesosController@ListarProcesosTermino');

    //estados
    Route::get('estados', 'EstadosController@index')->name('estados.show');
    Route::post('estados/save', 'EstadosController@save')->name('estados.save');
    Route::get('estados/listar', 'EstadosController@ListarRegistros');
    Route::get('estados/obtener/{id}/{procesoId}', 'EstadosController@ObtenerRegistro');
    Route::get('estados/del/{id}/{procesoId}', 'EstadosController@EliminarRegistro');

    //Empleos
    Route::get('empleos', 'EmpleosController@index')->name('empleos.show');
    Route::post('empleos/save', 'EmpleosController@save')->name('empleos.save');
    Route::get('empleos/listar', 'EmpleosController@ListarRegistros');
    Route::get('empleos/obtener/{id}', 'EmpleosController@ObtenerRegistro');
    Route::get('empleos/del/{id}', 'EmpleosController@EliminarRegistro');

    //Forma pago
    Route::get('formaPago', 'FormaPagoController@index')->name('formapago.show');
    Route::post('formaPago/save', 'FormaPagoController@save')->name('formapago.save');
    Route::get('formaPago/listar', 'FormaPagoController@ListarRegistros');
    Route::get('formaPago/obtener/{id}', 'FormaPagoController@ObtenerRegistro');
    Route::get('formaPago/del/{id}', 'FormaPagoController@EliminarRegistro');

    //Giros empresa
    Route::get('girosEmpresa', 'GirosEmpresaController@index')->name('giros.show');
    Route::post('girosEmpresa/save', 'GirosEmpresaController@save')->name('giros.save');
    Route::get('girosEmpresa/listar', 'GirosEmpresaController@ListarRegistros');
    Route::get('girosEmpresa/obtener/{id}', 'GirosEmpresaController@ObtenerRegistro');
    Route::get('girosEmpresa/del/{id}', 'GirosEmpresaController@EliminarRegistro');

    //PErfil
    Route::get('perfiles', 'PerfilController@index')->name('perfil.show');
    Route::post('perfiles/save', 'PerfilController@save')->name('perfil.save');
    Route::get('perfiles/listar', 'PerfilController@ListarRegistros');
    Route::get('perfiles/obtener/{id}', 'PerfilController@ObtenerRegistro');
    Route::get('perfiles/del/{id}', 'PerfilController@EliminarRegistro');

    //puestos bravos
    Route::get('puestos', 'PuestosController@index')->name('puestos.show');
    Route::post('puestos/save', 'PuestosController@save')->name('puestos.save');
    Route::get('puestos/listar', 'PuestosController@ListarRegistros');
    Route::get('puestos/obtener/{id}', 'PuestosController@ObtenerRegistro');
    Route::get('puestos/del/{id}', 'PuestosController@EliminarRegistro');
    
    //TipoEmpleado
    Route::get('tipoEmpleado', 'TipoEmpleadoController@index')->name('tipoEmpleado.show');
    Route::post('tipoEmpleado/save', 'TipoEmpleadoController@save')->name('tipoEmpleado.save');
    Route::get('tipoEmpleado/listar', 'TipoEmpleadoController@ListarRegistros');
    Route::get('tipoEmpleado/obtener/{id}', 'TipoEmpleadoController@ObtenerRegistro');
    Route::get('tipoEmpleado/del/{id}', 'TipoEmpleadoController@EliminarRegistro');
    
    //TipoServicioBravos
    Route::get('tipoServicio', 'TipoServicioController@index')->name('tipoServicio.show');
    Route::post('tipoServicio/save', 'TipoServicioController@save')->name('tipoServicio.save');
    Route::get('tipoServicio/listar', 'TipoServicioController@ListarRegistros');
    Route::get('tipoServicio/obtener/{id}', 'TipoServicioController@ObtenerRegistro');
    Route::get('tipoServicio/del/{id}', 'TipoServicioController@EliminarRegistro');

    //empleados
    Route::get('empleados', 'EmpleadosController@index')->name('empleados.show');
    Route::post('empleados/documentos/upload', 'EmpleadosController@uploadFiles')->name('empleados.docs.upload');
    Route::post('empleados/save', 'EmpleadosController@save')->name('empleados.save');
    Route::get('empleados/listar', 'EmpleadosController@ListarRegistros');
    Route::get('empleados/obtener/{id}', 'EmpleadosController@ObtenerRegistro');
    Route::get('empleados/listar/cbx', 'EmpleadosController@ListarEmpleadosCbx');

    //usuarios admin
    Route::get('usuarios', 'UsuariosAdminController@index')->name('admin.usuarios');
    Route::get('usuarios/obtener/{id}', 'UsuariosAdminController@ObtenerRegistro');
    Route::get('usuarios/listar', 'UsuariosAdminController@ListarRegistros')->name('admin.usuarios.listar');
    Route::post('usuarios/save', 'UsuariosAdminController@save')->name('admin.usuarios.save');
    


});
