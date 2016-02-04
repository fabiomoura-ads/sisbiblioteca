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
        'codigo', 'titulo', 'editora_id', 'categoria_id', 'autor', 'descricao', 'num_pag'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
}
