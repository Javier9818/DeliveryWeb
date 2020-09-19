<?php

use Illuminate\Support\Facades\Route;

Route::get('/intranet', 'Empresa\GeneralController@showCompany')->middleware('can:visit-company');
Route::get('/intranet/configuraciones', 'Empresa\GeneralController@showConfigurations')->middleware('can:edit-company, visit-company');
Route::get('/intranet/ubicacion', 'Empresa\GeneralController@showLocation')->middleware('can:edit-company, visit-company');
Route::get('/intranet/transporte', 'Empresa\GeneralController@showTransport')->middleware('can:gestionar-entregas, visit-company');


Route::get('/intranet/empleados', 'Empresa\EmpleadoController@showEmployees')->middleware('can:gestionar-personal, visit-company');
Route::get('/intranet/nuevo-empleado', 'Empresa\EmpleadoController@showNewEmployee')->middleware('can:gestionar-personal, visit-company');
Route::get('/intranet/empleado/edit/{id}', 'Empresa\EmpleadoController@editEmployee')->middleware('can:gestionar-personal, visit-company');



Route::get('/intranet/ventas', 'ContabilidadController@fn1')->middleware('can:gestionar-contabilidad, visit-company');
Route::get('/intranet/pagos', 'ContabilidadController@fn2')->middleware('can:gestionar-contabilidad, visit-company');
Route::post('/intranet/ventas/{funcion}', 'ContabilidadController@fn')->middleware('can:gestionar-contabilidad, visit-company');
Route::post('/intranet/pagos/{funcion}', 'ContabilidadController@fn')->middleware('can:gestionar-contabilidad, visit-company');

Route::get('/intranet/asignar-delivery', 'PedidosController@fn3')->middleware('can:gestionar-pedidos, visit-company');
Route::get('/intranet/estado-pedido', 'PedidosController@fn4')->middleware('can:gestionar-pedidos, visit-company');
Route::get('/intranet/estado-pedido/{funcion}', 'PedidosController@DetalleAsignacion')->middleware('can:gestionar-pedidos, visit-company');
Route::get('/intranet/pedidos-cocina', 'PedidosController@fn2')->middleware('can:gestionar-pedidos, visit-company');
Route::get('/intranet/pedidos', 'PedidosController@fn')->middleware('can:gestionar-pedidos, visit-company');
Route::post('/intranet/pedidos/{funcion}', 'PedidosController@fn')->middleware('can:gestionar-pedidos, visit-company');


Route::get('/intranet/categorias', 'CategoriasMenusController@fn')->middleware('can:gestionar-productos, visit-company');
Route::post('/intranet/categorias/{funcion}', 'CategoriasMenusController@fn')->middleware('can:gestionar-productos, visit-company');
Route::get('/intranet/productos', 'ProductosController@fn')->middleware('can:gestionar-productos, visit-company');
Route::post('/intranet/productos/{funcion}', 'ProductosController@fn')->middleware('can:gestionar-productos, visit-company');

Route::any('/extras/{funcion}', 'ExtrasController@fn');