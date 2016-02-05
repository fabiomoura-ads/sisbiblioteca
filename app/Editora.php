<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Editora extends Model
{
    protected $table = 'editoras';
    protected $fillable = [
        'nome', 'telefone', 'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
		'created_at', 'updated_at',
    ];

    public function livros(){
        return $this->hasMany('App\Livro');
    }
}
