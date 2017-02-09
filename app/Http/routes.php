<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['middleware' => 'web','as' => 'telaLogin', 'uses' =>'LoginController@telaLogin']);
//rotapara validar autenticação
Route::post('/', ['middleware' => 'web','as' => 'login', 'uses' =>'LoginController@validar']);
Route::get('sair', ['middleware' => 'web','as' => 'sair', 'uses' =>'LoginController@sair']);


/*
* Rotas autenticadas
*/
Route::group(['middleware' => ['web','auth']], function()
{

Route::get('listaprocessos', ['as' => 'index', 'uses' =>'ProcessoController@index']);
Route::get('processo/{id}',  ['as' => 'processo', 'uses' =>'ProcessoController@show']);
Route::get('historico/{id}',  ['as' => 'historico', 'uses' =>'ProcessoController@historico']);
Route::get('baixaanexo/{id}/{anexo}',  ['as' => 'anexoDown', 'uses' =>'ProcessoController@pedeAnexo']);
Route::get('checaanexo/{id}',  ['as' => 'anexoCheck', 'uses' =>'ProcessoController@checaAnexo']);
Route::get('historico/{id}',  ['as' => 'historico', 'uses' =>'ProcessoController@historico']);

});

/*
*	rotas para testes
*/
Route::get('/teste', ['as' => 'p1', 'uses' =>'TestController@testar']);
