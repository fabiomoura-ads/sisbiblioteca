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
    $users = DB::table("users")->get();
	return $users;
});

Route::get('/users', "UserController@getAll" );

Route::group(['prefix' => 'api', 'middleware' => 'cors'], function(){
	Route::resource("locacao", "LocacaoController");
	Route::resource("editora", "EditoraController");
	Route::resource("aluno", "AlunoController");
	Route::resource("livro", "LivroController");
	Route::resource("categoria", "CategoriaController");
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
