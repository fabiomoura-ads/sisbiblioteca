<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	/**
	 * Método getMessageReturn() foi criado para encapsular a montagem das respostas 
	 * dos Controllers para a view. Recebe um array com o resultado e um identificador 
	 * da operação realizada. E retornará um array resposta, com informações para view;
	 * @params: Array $result, String $identificadorOperacao;
	 * @return: Array $resposta;
	 * @author: Fábio Moura, em 31/01/2016
	 **/	
	public function getMessageReturn($result, $identificadorOperacao, $mensagem, $tipo ){
		
		$resposta = array();

		if ( $mensagem && $tipo ) {			
			array_push( $resposta, $tipo, $mensagem );
			return $resposta;
		}	
		
		$operacao = $this->getTipoOperacao($identificadorOperacao);
		
		if ( $result && !empty($result) && count($result) > 0 ) {
			
			$tipo = "success";
			
			if ( count($result) > 1 ) {
				$mensagem = "Registros de " .$this->CLASS_NAME. " ".$operacao."s com sucesso!";
			} else {
				$mensagem = "Registro de " .$this->CLASS_NAME. " ".$operacao." com sucesso!";			
			}
			
			array_push( $resposta, $tipo, $mensagem, $result );				
			
		} else {
			
			$tipo = "error";
			$mensagem = "Não foi ".$operacao." o registro de " .$this->CLASS_NAME. ".";
			
			array_push( $resposta, $tipo, $mensagem );								
			
		}
		
		if ( !$tipo || !$mensagem ) {
			array_push( $resposta, "Não foi possível montar a mensagem de retorno, Controller.getMessageReturn(), parametro recebido: " .$result );
			return $resposta;
		}
				
		return $resposta;
	
	}	

	/*
	 * Método getTipoOperacao(), criado para verificar qual tipo de operação
	 * está sendo realizada, para exibir a mensagem específica por operação;
	 * @params String $identificadorOperacao
	 * @return String $operacao
	 * @author: Fábio Moura, em 09/02/2016
	 **/
	public function getTipoOperacao($identificadorOperacao){
		$identificadorOperacao = strtoupper($identificadorOperacao);
		$operacao = null;
		
		if ( $identificadorOperacao == "I" ) {
			$operacao = "inserido";
		} else if ( $identificadorOperacao == "D" ) {
			$operacao = "removido";			
		} else if ( $identificadorOperacao == "U" ) {
			$operacao = "atualizado";			
		} else if( $identificadorOperacao == "S" ) { 
			$operacao = "localizado";			
		}
		
		return $operacao;
	}	
}
