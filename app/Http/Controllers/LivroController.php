<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Livro;
use Validator;
use App\Categoria;

class LivroController extends Controller
{
	protected $context;
	protected $CLASS_NAME = "Livro";
	
	public function __construct(Livro $context){
		$this->context = $context;
	}
	
    public function index(){
		$op = "S";
		$result = $this->context->with('categorias')->with('editoras')->get();		
		return $this->getMessageReturn($result, $op);		
    }

    public function store(Request $request) {
		$op = "I";
		
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
			return $validator->errors();
		}
		
		$result = $this->context->create($request->all());		
		return $this->getMessageReturn($result, $op);	
    }

    public function show($id) {
		$op = "S";
		$result = $this->context->with('categorias')->with('editoras')->find($id);
		return $this->getMessageReturn($result, $op);
    }

    public function update(Request $request, $id) {
		$op = "U";
		
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
			return $validator->errors();
		}
		
		$result = $this->context->find($id);
		if ( $result ){
			$result = $result->update($request->all());			
		}	
		return $this->getMessageReturn($result, $op);
    }

    public function destroy($id) {
		$op = "D";
		
		$result = $this->context->find($id);
		if ( $result ) {
			$result = $result->delete();	
		}				
		return $this->getMessageReturn($result, $op);		
    }
}
