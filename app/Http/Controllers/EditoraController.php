<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use App\Editora;

class EditoraController extends Controller
{
    protected $context;
	protected $CLASS_NAME = "Editora";

    public function __construct(Editora $context){
    	$this->context = $context;
    }

    public function index(){
		$op = "S";
		$result = $this->context->all();		
		return $result;
		//return $this->getMessageReturn($result, $op, null, null);	
    }

    public function store(Request $request){
    	$op = "I";
		
    	$validator = Validator::make(
    		$request->all(),
    		[
    			'nome' => 'required',
    			'email' => 'required|email|unique:editoras',
				'telefone' => 'required|min:8'
    		]

    	);

    	if($validator->fails()){
    		//return $validator->errors();			
    		return response()->json(['error' => $validator->errors()], 401);
		}
		
		$result = $this->context->create($request->all());		
		//return $this->getMessageReturn($result, $op, null, null);
		return $result;		

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
    			'nome' => 'required',    
    			'email' => 'required|email|unique:editoras,email,'.$id,
				'telefone' => 'required|min:8'
    		]
    	);
		
		if ( $validator->fails() ) {
			return $validator->errors();			
		} 
			
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
	