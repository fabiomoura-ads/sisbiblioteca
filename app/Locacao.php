<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locacao extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $table = "locacoes";
	public $timestamps = false;
    protected $fillable = [
        'aluno_id', 'livro_id', 'data_locacao', 'data_devolucao', 'status', 
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
		'aluno_id', 'livro_id',
    ];
	
	public function alunos(){
		return $this->belongsTo("App\Aluno", "aluno_id");
	}
	
	public function livros(){
		return $this->belongsTo("App\Livro", "livro_id");
	}    
}
