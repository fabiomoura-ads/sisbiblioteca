<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public $erros = array();
	
	/**
	 * Método para validar a passagem de parâmetro para uma função.
	 * Parametros: 
	 * $funcao = Nome da função que está sendo executada;
	 * $parametro = Nome do parâmetro a ser verificado;
	 * $valor = Valor do parêmtro para ser verificado se existe;
	 * $tipo = Opcional, para validar o tipo de valor
	 * Por: Fábio Moura, em 31/01/2016
	 **/
	public function validaPassagemDeParametro($funcao, $parametro, $valor, $tipo){		
		if ( $valor == null) {
			$mensagem = ["error", "Parametro '".$parametro."' obrigatorio para chamada da funcao ".$funcao.", verifique!"];
			array_push($this->erros, $mensagem);		
		}
	}	
	
}
