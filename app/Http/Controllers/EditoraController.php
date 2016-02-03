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
		$result = $this->context->all();
		
		if ( $result && !empty($result) && count($result) > 0 ) {
			return $result;
		}
		return $this->getMessageReturn("error", "não possui registros!", null, null );	
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
    		return $validator->errors();			
		}
		
		$result = $this->context->create($request->all());
		
		if ( $result ) {
			return $this->getMessageReturn("success", "inserida com sucesso!", $result, $result["nome"] );			
		} 
		
		return $this->getMessageReturn("error", "não foi inserida, verifique!", null, null );			
    }


    public function show($id){
		$result = $this->context->find($id);
		if ( $result ) {
			return $this->getMessageReturn("success", "localizado", $result, $result["nome"]);			
		}
		
		return $this->getMessageReturn("error", "não localizada", null, $id);			
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
			return $validator->errors();			
		} 
			
		$result = $this->context->find($id);
						
		if ( $result ) {
			$result->update($request->all()); 				
			return $this->getMessageReturn("success", "atualizada com sucesso!", $result, $result["nome"] );			
		} 
		
		return $this->getMessageReturn("error", "não foi atualizada, verifique!", null, null );								
    }

    public function destroy($id){
		$result = $this->context->find($id);
		
		if ( $result ) {
			$nome = $result->nome;
			
			if ( $result->delete() ){ 
				return $this->getMessageReturn("success", "excluída com sucesso!", null, $nome);			
			} 
			
			return $this->getMessageReturn("error", "não foi possível excluir, verifique!", null, $id);			
		}
		
		return $this->getMessageReturn("error", "não foi localizada!", null, $id);			
		
    }
}
	