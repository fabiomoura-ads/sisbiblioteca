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
    
    public function __construct(Editora $context){
    	$this->context = $context;
    }

    public function index(){
		return $this->context->all();		
    }

    public function store(Request $request){
    	$validator = Validator::make(
    		$request->all(),
    		[
    			'nome' => 'required',
    			'email' => 'required|email|unique:editoras',
				'telefone' => 'required|min:8'
    		]

    	);

    	if($validator->fails()){
    		return response()->json(['error' => $validator->errors()], 401);
		}
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
    			'nome' => 'required',    
    			'email' => 'required|email|unique:editoras,email,'.$id,
				'telefone' => 'required|min:8'
    		]
    	);
		
		if ( $validator->fails() ) {
			return response()->json(['error' => $validator->errors()], 401);
		} 
		$result = $this->context->find($id);						

		if ( $result ){
			$result->update($request->all());
		}
        return $this->context->find($id);
    }

    public function destroy($id){
		$result = $this->context->find($id);
		if ( $result ) {
			$result->delete();	
			return $result;
		}				
		return response()->json(['error' => 'Erro ao remover editora.'], 401);
    }
}
	