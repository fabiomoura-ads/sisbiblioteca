<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $table = 'categorias';
    protected $fillable = [
        'nome', 
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    public function livros(){
        return $this->hasMany('App\Livro');
    }
}
