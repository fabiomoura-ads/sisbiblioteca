<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	//public $timestamps = false;
	
    protected $fillable = [
        'matricula', 'nome', 'email', 'telefone', 'status',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
		'created_at', 'updated_at',
    ];
	
	public function locacoes(){
		return $this->hasMany("App\Locacao");
	}
	
	public function scopeActive($query){
		return $query->where("status", 1);
	}	
}
