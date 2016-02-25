<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Categoria, App\Editora,App\Livro, App\Locacao, App\Aluno;

class MainController extends Controller
{
	protected $categoria;
	protected $editora;
	protected $livro;
	protected $locacao;
	protected $aluno;

    public function __construct(Categoria $categoria, Editora $editora, Livro $livro, Locacao $locacao, Aluno $aluno){
    	$this->categoria = $categoria;
    	$this->editora = $editora;
    	$this->livro = $livro;
    	$this->locacao = $locacao;
    	$this->aluno = $aluno;
    }

    public function index(){
    	return [
    		'categorias' => collect($this->categoria->all())->count(),
    		'editoras' => collect($this->editora->all())->count(),
    		'livros' => collect($this->livro->all())->count(),
    		'locacoes' => collect($this->locacao->all())->count(),
    		'alunos' => collect($this->aluno->all())->count(),
    	];
    }
}
