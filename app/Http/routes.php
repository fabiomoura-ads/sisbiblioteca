<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return 'Welcome';	
});

Route::group(['prefix' => 'api', 'middleware' => 'cors'], function(){

	Route::post('authenticate', 'UserController@authenticate');	
	
	Route::group(['middleware' => 'jwt.auth', ['except' => ['authenticate']]], function(){

		Route::get('authenticate/user', 'UserController@getAuthenticatedUser');
		Route::resource('authenticate', 'UserController', ['only' => ['index']]);
		Route::resource("locacao", "LocacaoController");
		Route::resource("editora", "EditoraController");
		Route::resource("aluno", "AlunoController");
		Route::resource("livro", "LivroController");
		Route::resource("categoria", "CategoriaController");
		Route::resource("parametro", "ParametroController");

	});
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/


Route::group(['middleware' => ['web']], function () {
    //
});
