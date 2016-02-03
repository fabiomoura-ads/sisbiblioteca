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
	 * Método getMessageReturn() foi criado para encapsular as mensagens de retorno para view,
	 * sendo parametrizável para qualque tipo de retorno, atráves dos parametros recebidos;
	 * $tipo = Tipo de mensagem de retorno, "sucess" ou "error"; ( obrigatório )
	 * $mensagem = Mensagem que será retornada; ( obrigatório )
	 * $retorno = Retorno dos metodos de persistencia ( opcional )
	 * $nome = Nome do registro que está sendo manipulado ( opcional ) 
	 * Por: Fábio Moura, em 31/01/2016
	 **/
	public function getMessageReturn($tipo, $mensagem, $retorno, $nome){
		
		$resposta = array();	
		
		if ( !$tipo || !$mensagem ) {
			array_push( $resposta, ["Não foi possível montar a mensagem de retorno, Controller.getMessageReturn()"] );
			return $resposta;
		}
		
		array_push( $resposta, $tipo );
		
		if ( $mensagem && $nome ) {
			array_push( $resposta, $this->CLASS_NAME." '".$nome."' ".$mensagem );							
		} else if ( $mensagem ) {
			array_push( $resposta, $this->CLASS_NAME." ".$mensagem );							
		} 
		if ( $retorno ) {
			array_push( $resposta, $retorno );	
		} 
		
		
		return $resposta;
	
	}	
}
