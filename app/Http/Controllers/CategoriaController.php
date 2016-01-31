<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Categoria;


class CategoriaController extends Controller
{
	
	public function getIndex(){
		return Categoria::all();
	}
	
	/*
		Criado a getInserir para testar mais facil, ele só chama o post, quando for pra produção comentar esse método;
		Por: Fábio Moura, 31/01/2016
	*/
	public function getInserir(Request $request){
		return $this->postInserir($request);
	}
	
	/**
	 * Método postInserir(), recebe o request e pode trabalhar com todos os parêmtros 
	 * do formulário. O nome é inserido com a primeira letra maiúscula, para padronizar;
	 * Por: Fábio Moura, 31/01/2016
	 **/
	public function postInserir(Request $request){		
		$nome = $request->input("nome");
		$nome = strtolower($nome);
		$nome = ucfirst($nome);	
		
		$categoria = new Categoria;
		$categoria->nome = $nome;
		$categoria->save();
		
		return "Categoria ".$categoria->nome. " inserida com sucesso!";				
	}	
	
	public function getBuscar(Request $request){
		
		$id = $request->input("id");
		$categoria = new Categoria;
		$categoria = $categoria->find($id);

		return $categoria;
	}
	
	public function postAtualizar(Request $request){
		$id = $request->input("id");
		$nomeAtual = $request->input("nome");
				
		$categoria = new Categoria;
		$categoria = $categoria->find($id);		
		$nomeAnterior = $categoria->nome;	

		$categoria->update(["nome" => $nomeAtual]);
		
		return "Categoria ". $nomeAnterior. " atualizada para ". $nomeAtual;			
	}
	
	public function postDeletar(Request $request){
		$id = $request->input("id");
		$categoria = new Categoria;
		$categoria = $categoria->find($id);
		if ( $categoria != null ) {
			$nome = $categoria->nome;
			$categoria->delete();
			return "Categoria ".$nome." excluída com sucesso!";
		}  
		
		return "Não foi localizado categoria de id ".$id;	
	}
}
