<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use App\Parametro;

class ParametroController extends Controller
{	
	protected $context;
	protected $CLASS_NAME = "Parametro";
	
	public function __construct(Parametro $context){
		$this->context = $context;
	}
	
	public function index(){
		$op = "S";
		$result = $this->context->all();		
		return $this->getMessageReturn($result, $op);	
	}
	
	public function store(Request $request){		
		$op = "I";	
		
		$validator = Validator::make(
			$request->all(), 
			[
				'parametro' => 'required'				
			]
		);
		
		if ( $validator->fails() ) {
			return $validator->errors();			
		};		
		
		$result = $this->context->create($request->all());		
		return $this->getMessageReturn($result, $op);			
	}	
	
	public function show($id){			
		$op = "S";		
		$result = $this->context->find($id);		
		return $this->getMessageReturn($result, $op);		
	}
	
	public function update(Request $request, $id){
		$op = "U";	
		
		$validator = Validator::make(
			$request->all(), 
			[
				'parametro' => 'required',
			]
		);
		
		if ( $validator->fails() ) {
			return $validator->errors();			
		}; 	
		
		$result = $this->context->find($id);
		if ( $result ){
			$result = $result->update($request->all());			
		}		
		return $this->getMessageReturn($result, $op);									
	}
		
	public function destroy($id){
		$op = "D";	
		$result = $this->context->find($id);
		if ( $result ) {
			$result = $result->delete();	
		}		
		return $this->getMessageReturn($result, $op);										
	}
		
}
