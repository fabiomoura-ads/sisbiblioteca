<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'codigo', 'titulo', 'autor', 'descricao', 'num_pag', 'editora_id', 'categoria_id', 'qtd_disponivel', 'qtd_total',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
		 'editora_id', 'categoria_id', 	'created_at', 'updated_at',
    ];

    public function editoras(){
        return $this->belongsTo('App\Editora', 'editora_id');
    }

    public function categorias(){
        return $this->belongsTo('App\Categoria', 'categoria_id');
    }
	
    public function locacoes(){
        return $this->hasMany('App\Locacao');
    }	

}
