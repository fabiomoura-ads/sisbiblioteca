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
	
	public static function getQtdLocacaoPorAluno(){
		return DB::table("parametros")->where("parametro", "qtd_locacao_por_aluno")->value("qtd");
	}
	
	public static function getPrazoDevolucao(){
		return DB::table("parametros")->where("parametro", "prazo_devolucao")->value("qtd");
	}	
	
}
