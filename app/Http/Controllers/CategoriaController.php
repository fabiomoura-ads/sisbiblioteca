<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use App\Categoria;
use Response;

class CategoriaController extends Controller
{	
	protected $context;
		
	public function __construct(Categoria $context){
		$this->context = $context;
	}
	
	public function index(){
		return $this->context->all();		
	}
	
	public function store(Request $request){		
		$validator = Validator::make(
			$request->all(), 
			[
				'nome' => 'required|unique:categorias|min:5'
			]
		);
		
		if ( $validator->fails() ) {	
			return response()->json($validator->errors(), 401);
		};		
		
		$result = $this->context->create($request->all());		
		return $result;
	}	
	
	public function show($id){			
		return $this->context->find($id);		
	}
	
	public function update(Request $request, $id){
		$validator = Validator::make(
			$request->all(), 
			[
				'nome' => 'required|unique:categorias|min:5|max:40'.$id
			]
		);
		
		if ( $validator->fails() ) {
			return response()->json($validator->errors(), 401);
		}; 	
		
		$result = $this->context->find($id);
		if ( $result ){
			$result->update($request->all());			
		}

		return $result;
	}
		
	public function destroy($id){
		$result = $this->context->find($id);
		
		if ($result) {
			$result->delete();	
		}
		return $result;
		
	}
		
}
