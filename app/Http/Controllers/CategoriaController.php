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
		return $this->context->all();
	}
	
	public function store(Request $request){		

		$validator = Validator::make(
			$request->all(), 
			[
				'nome' => 'required|min:5'
			]
		);
		
		if ( $validator->fails() ) {
			return $validator->errors();			
		};		
				
		$resposta = $this->context->create($request->all());
		
		if ( $resposta ) {
			return $this->getMessageReturn("success", "inserida com sucesso!", $resposta, $resposta["nome"] );			
		} 
		
		return $this->getMessageReturn("error", "não foi inserida, verifique!", $resposta, null );			
		
	}	
	
	public function show($id){			
		
		$categoria = $this->categoria->find($id);
		
		if ( !categoria ) {
			return $this->getMessageReturn("error", "não foi localizada!", null, $id);			
		}

		return $categoria;
	}
	
	public function update(Request $request){
		
		$validator = Validator::make(
			$request->all(), 
			[
				'id' => 'required|numeric',
				'nome' => 'required|min:5|max:40'
			]
		);
		
		if ( $validator->fails() ) {
			return $validator->errors();			
		} 
				
		$id = $request->input("id");
		$nome = $request->input("nome");	
				
		$categoria = $this->categoria->find($id);
		
		if ( $categoria ) {
			
			if ( $categoria->update(["nome" => $nome]) ) {
				return $this->getMessageReturn("success", "atualizada com sucesso!", $nome);			
			} 

			return $this->getMessageReturn("error", "não foi atualizada, verifique!", $id);			

		} 
		
		return $this->getMessageReturn("error", "não foi localizada", $id);									
	}
		
	public function destroy($id){
		
		$categoria = $this->categoria->find($id);

		if ( $categoria ) {
			$nome = $categoria->nome;
			
			if ( $categoria->delete() ){ 
				return $this->getMessageReturn("success", "excluída com sucesso!", $nome);			
			} 
			
			return $this->getMessageReturn("error", "não foi possível excluir, verifique!", $id);			
		}
		
		return $this->getMessageReturn("error", "não foi localizada!", $id);			
		
	}
		
}
