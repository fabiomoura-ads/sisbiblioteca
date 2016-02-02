<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Categoria;
use Validator;


class CategoriaController extends Controller
{
	
	protected $categoria;
	protected $CLASS_NAME = "Categoria";
	
	public function __construct(Categoria $categoria){
		$this->categoria = $categoria;
	}
	
	public function getIndex(){
		return $this->categoria->all();
	}
	
	public function postStore(Request $request){		

		$validator = Validator::make(
			$request->all(), 
			[
				'nome' => 'required|min:5'
			]
		);
		
		if ( $validator->fails() ) {
			return $validator->errors();			
		} 	
		
		$nome = $request->input("nome");
		
		$nome = strtolower($nome);
		$nome = ucfirst($nome);	
		
		$categoria = $this->categoria;
		$categoria->nome = $nome;
		
		if ( $categoria->save() ) {			
			$mensagem = $this->getMessageReturn("success", "inserida com sucesso!", $nome );	
		} else {
			$mensagem = $this->getMessageReturn("error", "não foi inserida, verifique!", $nome );			
		}
		
		return $mensagem;
	}	
	
	public function getShow($id){		
		$categoria = $this->categoria->find($id);
		
		if ( !$categoria ) {
			return $this->getMessageReturn("error", "não foi localizada!", $id);			
		}

		return $categoria;
	}
	
	public function postUpdate(Request $request){
		
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
		
	public function postDestroy($id){
		
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
