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
    protected $fillable = [
        'aluno_id', 'livro_id', 'data_locacao', 'data_devolucao', 'status', 
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
}
