<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use App\Categoria;

class CategoriaController extends Controller
{	
	protected $context;
	protected $CLASS_NAME = "Categoria";
	
	public function __construct(Categoria $context){
		$this->context = $context;
	}
	
	public function index(){
		$op = "S";
		$result = $this->context->all();		
		return $this->getMessageReturn($result, $op, null, null);	
	}
	
	public function store(Request $request){		
		$op = "I";	
		
		$validator = Validator::make(
			$request->all(), 
			[
				'nome' => 'required|min:5'
			]
		);
		
		if ( $validator->fails() ) {
			return $validator->errors();			
		};		
		
		$result = $this->context->create($request->all());		
		return $this->getMessageReturn($result, $op, null, null);			
	}	
	
	public function show($id){			
		$op = "S";		
		$result = $this->context->find($id);		
		return $this->getMessageReturn($result, $op, null, null);		
	}
	
	public function update(Request $request, $id){
		$op = "U";	
		
		$validator = Validator::make(
			$request->all(), 
			[
				'nome' => 'required|min:5|max:40',
			]
		);
		
		if ( $validator->fails() ) {
			return $validator->errors();			
		}; 	
		
		$result = $this->context->find($id);
		if ( $result ){
			$result = $result->update($request->all());			
		}		
		return $this->getMessageReturn($result, $op, null, null);									
	}
		
	public function destroy($id){
		$op = "D";	
		$result = $this->context->find($id);
		if ( $result ) {
			$result = $result->delete();	
		}		
		return $this->getMessageReturn($result, $op, null, null);										
	}
		
}
