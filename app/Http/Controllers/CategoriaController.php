<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Categoria;


class CategoriaController extends Controller
{
	
	protected $categoria;
	protected $CLASS_NAME = "Categoria";
	
	public function __construct(Categoria $categoria){
		$this->categoria = $categoria;
		$erros = array();
	}
	
	public function getIndex(){
		return Categoria::all();
	}
	
	public function postStore($nome){		
		$funcao = "postStore()";

		$this->validaPassagemDeParametro($funcao, "nome", $nome, null);
		
		if ( count($this->erros) > 0 ) {
			return $this->erros;
		}		
				
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
		$funcao = "getShow()"; 
			
		$this->validaPassagemDeParametro($funcao, "id", $id, null);
		
		if ( count($this->erros) > 0 ) {
			return $this->erros;
		}
		
		$categoria = $this->categoria;
		$categoria = $categoria->find($id);
		
		if ( !$categoria ) {
			return $this->getMessageReturn("error", "não foi localizada!", $id);			
		}

		return $categoria;
	}
	
	public function postUpdate(Request $request){
		$funcao = "postUpdate()";
		
		$id = $request->input("id");
		$nome = $request->input("nome");
		
		$this->validaPassagemDeParametro($funcao, "id", $id, null);
		$this->validaPassagemDeParametro($funcao, "nome", $nome, null);
		
		if ( count($this->erros) > 0 ) {
			return $this->erros;
		}			
				
		$categoria = $this->categoria->find($id);
		
		if ( !$categoria ) {
			return $this->getMessageReturn("error", "nao foi localizada", $id);			
		} 
		
		if ( $categoria->update(["nome" => $nome]) ) {
			return $this->getMessageReturn("success", "atualizada com sucesso!", $nome);			
		}
		
		return $this->getMessageReturn("error", "nao foi atualizada, verifique!", $id);			
	}
		
	public function postDestroy($id){
		$funcao = "postDestroy()";
		
		$this->validaPassagemDeParametro($funcao, "id", $id, null);
		
		if ( count($this->erros) > 0 ) {
			return $this->erros;
		}	

		$categoria = $this->categoria->find($id);

		if ( $categoria ) {
			$nome = $categoria->nome;
			
			if ( $categoria->delete() ){ 
				return $this->getMessageReturn("success", "excluida com sucesso!", $nome);			
			} 
			
			return $this->getMessageReturn("error", "nao foi excluida, verifique!", $id);			
		}
		
		return $this->getMessageReturn("error", "nao foi localizada!", $id);			
		
	}
	
	/**
	 * Método getMessageReturn() foi criado para encapsular as mensagens de retorno para view,
	 * sendo parametrizável para qualque tipo de retorno, atráves dos parametros recebidos;
	 * $tipo = Tipo de mensagem de retorno, "sucess" ou "error"; ( obrigatório )
	 * $mensagem = Mensagem que será retornada; ( obrigatório )
	 * $nome = Nome do registro que está sendo manipulado ( opcional ) 
	 * Por: Fábio Moura, em 31/01/2016
	 **/
	public function getMessageReturn($tipo, $mensagem, $nome){
		
		if ( $nome ) {
			$mensagem = $this->CLASS_NAME." ".$nome." ".$mensagem;	
		} else {
			$mensagem = $this->CLASS_NAME." ".$mensagem;				
		} 
		
		$resposta = [$tipo => $mensagem];
		return $resposta;
	}
		
	public function getFail($acao){
		return ["error" => "Não foi possível ".$acao." o registro!\nEntre em contato com o administrador do sistema."];
	}	

}
