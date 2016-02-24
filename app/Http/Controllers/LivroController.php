<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Livro;
use Validator;
use App\Categoria;
use Response;

class LivroController extends Controller
{
	protected $context;
	
	public function __construct(Livro $context){
		$this->context = $context;
	}
	
    public function index(){
		return $this->context->with('categorias')->with('editoras')->get();		
    }

    public function store(Request $request) {
        $validator = Validator::make(
			$request->all(),
			[
				'codigo' => 'required|unique:livros',
				'titulo' => 'required',
				'autor' => 'required',
				'categoria_id' => 'required',
				'editora_id' => 'required'	
				
			]
		);
		
		if ( $validator->fails() ) {
			return response()->json(['error' => [ $validator->errors()->first() ] ], 401);
		}
		
		$result = $this->context->create($request->all());
		return $result->with('categorias')->with('editoras')->get();		
		
    }

    public function show($id) {
		return $this->context->with('categorias')->with('editoras')->find($id);
		
    }

    public function update(Request $request, $id) {
	
        $validator = Validator::make(
			$request->all(),
			[
				'codigo' => 'required|unique:livros,codigo,'.$id,
				'titulo' => 'required',
				'autor' => 'required',
				'categoria_id' => 'required',
				'editora_id' => 'required'				
			]
		);
		
		if ( $validator->fails() ) {
			return response()->json(['error' => [ $validator->errors()->first() ] ], 401);
		}
		
		$result = $this->context->find($id);
		if ( $result ){
			$result->update($request->all());			
		}	

		return $result;
		
    }

    public function destroy($id) {
		$result = $this->context->find($id);
		if ( $result ) {
			$result->delete();	
		}				
		return $result;
    }
}
