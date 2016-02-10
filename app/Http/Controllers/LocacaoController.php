<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Locacao;
use App\Livro;
use App\Aluno;
use App\Parametro;
use Validator;

/**
 * 0 = Livro Alugado
 * 1 = Livro Devolvido
 **/
class LocacaoController extends Controller
{
	protected $context;
	protected $CLASS_NAME = "Locacao";
	protected $QTD_LOCACAO_POR_ALUNO;	
	protected $PRAZO_DEVOLUCAO;	
	
	
	public function __construct(Locacao $context){
		$this->context = $context;
	}
	
    public function index(){
		$op = "S";		
		$result = $this->context->with('alunos')->with('livros')->get();
		return $this->getMessageReturn($result, $op, null, null);
    }
    
    public function store(Request $request){
		$op = "I";		
		$result = null;		
		$podeLocar = $this->alunoPodeLocar($request->input("qtd"));
				
		if ( $podeLocar ) {
			
			$validator = Validator::make(
				$request->all(),
				[
					'aluno_id' => 'required',
					'livro_id' => 'required'				]
			);
					
			if ( $validator->fails() ) {
				return $validator->errors();
			}
		
			$request = $this->geraDatasDaLocacao($request);
			
			$result = $this->context->create($request->all());
			
		} 
		
		return $this->getMessageReturn($result, $op, null, null);
    }

    public function show($id) {
		$op = "S";
		$result = $this->context->with('alunos')->with('livros')->find($id);
		return $this->getMessageReturn($result, $op, null, null);
    }
      
    public function update(Request $request, $id) {
		$op = "U";		
		
        $validator = Validator::make(
			$request->all(),
			[
				'aluno_id' => 'required',
				'livro_id' => 'required',
				//'data_locacao' => 'required',
				//'data_devolucao' => 'required'		
			]
		);
		
		if ( $validator->fails() ) {
			return $validator->errors();
		}
		
		$result = $this->context->find($id);
		if ( $result ){
			$result = $result->update($request->all());			
		}	
		return $this->getMessageReturn($result, $op, null, null);
    }
	
    public function destroy($id) {
		$op = "D";
		
		$result = $this->context->find($id);
		if ( $result ) {
			$result = $result->delete();	
		}				
		return $this->getMessageReturn($result, $op, null, null);		
    }
	
	/**
	 * Método para verificar se o aluno ainda pode locar livros, 
	 * de acordo com a quantidade especificada na parametrização
	 * para limite de livros alugados por aluno;
	 * @params integer $qtdParaLocacao
	 * @return boolean;
	 * @author Fábio Moura, em 09/02/2016
	 **/
	public function alunoPodeLocar( $qtdParaLocacao ){		
		
		$this->carregaParametros();
		$qtdLocado = 0;
		
		$result = $this->context->where("aluno_id", 1)->where("status", 0 /* locado */ )->get();
		
		if ( $result && count($result) > 0 ) {

			//quantidade de livros alugados pelo aluno
			$qtdLocado = count($result);		
		}
		
		//quantidade disponivel é a quantidade parametrizada - quantidade alugada, 
		$qtdDisponivelParaLocacao = ( $this->QTD_LOCACAO_POR_ALUNO - $qtdLocado );			
		
		//se a quantidade disponível for > 1, entra no if, senão retorna false, informando que o aluno ja está no limite de aluguel;
		if ( $qtdDisponivelParaLocacao ){
					
			//a quantidade para locação deve ser menor ou igual a quantidade disponivel para locação;
			if ( $qtdParaLocacao <= $qtdDisponivelParaLocacao ) {
				//return $qtdDisponivelParaLocacao;			
				return true;
			}			
		} 						
				
		return false;
	}
	
	public function geraDatasDaLocacao( $request ){
		$hoje = new Date();
		$dia = $hoje("d"); 
		$dia = $hoje("d");
		$dia = $hoje("d");		
	}
	/**
	 * Método para carregar os parametros gravados, caso não exista, configura
	 * valores default;
	 * @author: Fábio Moura, em 09/02/2016
	 **/
	public function carregaParametros(){
				
		if ( !$this->QTD_LOCACAO_POR_ALUNO ) {
			$this->QTD_LOCACAO_POR_ALUNO = Parametro::getQtdLocacaoPorAluno();	
			if ( !$this->QTD_LOCACAO_POR_ALUNO ) {
				$this->QTD_LOCACAO_POR_ALUNO = 2;
			}
		} 
				
		if ( !$this->PRAZO_DEVOLUCAO ) {
			$this->PRAZO_DEVOLUCAO = Parametro::getPrazoDevolucao();
			if ( !$this->PRAZO_DEVOLUCAO ) {
				$this->PRAZO_DEVOLUCAO = 7;
			}
		}
	}
}
