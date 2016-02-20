<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Parametro extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $QTD_LOCACAO_POR_ALUNO;
	public $PRAZO_DEVOLUCAO;
	
	protected $table = "parametros";

    protected $fillable = [
        'parametro', 'qtd', 'observacao'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
		
    ];
	
	public function getQtdLocacaoPorAluno(){
		return DB::table("parametros")->where("parametro", "qtd_locacao_por_aluno")->value("qtd");
	}
	
	public function getPrazoDevolucao(){
		return DB::table("parametros")->where("parametro", "prazo_devolucao")->value("qtd");
	}
	
	/**
	 * Método para carregar os parametros gravados, caso não exista, configura
	 * valores default;
	 * @author: Fábio Moura, em 09/02/2016
	 **/	
	public function getParametrizacao(){
		
		if ( !$this->QTD_LOCACAO_POR_ALUNO ) {
			$this->QTD_LOCACAO_POR_ALUNO = $this->getQtdLocacaoPorAluno();	
			if ( !$this->QTD_LOCACAO_POR_ALUNO ) {
				$this->QTD_LOCACAO_POR_ALUNO = 2;
			}
		} 
						
		if ( !$this->PRAZO_DEVOLUCAO ) {
			$this->PRAZO_DEVOLUCAO = $this->getPrazoDevolucao();
			if ( !$this->PRAZO_DEVOLUCAO ) {
				$this->PRAZO_DEVOLUCAO = 7;
			}
		}
		
	}	
}
