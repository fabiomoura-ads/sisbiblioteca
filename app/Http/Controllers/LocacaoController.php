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
use Datetime;

/**
 * 0 = Livro Alugado
 * 1 = Livro Devolvido
 **/
class LocacaoController extends Controller
{
	protected $context;
	protected $CLASS_NAME = "Locacao";
	protected $parametros;
	
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
		
		$podeLocar = $this->alunoPodeLocar($request);
		
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
									
			$request = $this->geraDatasLocacaoDevolucao($request);
			$result = $this->context->create($request->all());
			if ( $result && $result["id"] ) {
				return $this->show($result["id"]);
			}			
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
				'livro_id' => 'required'
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
	public function alunoPodeLocar( $request ){		
				
		$this->parametros = new Parametro();		
		$this->parametros->getParametrizacao();
		
		$qtdLocado = 0;
		
		$aluno = $request->input("aluno_id");
		$qtdParaLocacao = $request->input("qtd");
				
		if ( !$aluno || !$qtdParaLocacao ) {
			return false;
		} 
		
		$result = $this->context->where("aluno_id", $aluno)->where("status", 0 /* livro locado */ )->get();
		
		if ( $result && count($result) > 0 ) {

			//quantidade de livros alugados pelo aluno
			$qtdLocado = count($result);		
		}
		
		//quantidade disponivel é a quantidade parametrizada - quantidade alugada, 
		$qtdDisponivelParaLocacao = ( $this->parametros->QTD_LOCACAO_POR_ALUNO - $qtdLocado );			
				
		//se a quantidade disponível for > 1, entra no if, senão retorna false, informando que o aluno ja está no limite de aluguel;
		if ( $qtdDisponivelParaLocacao ){
							
			//a quantidade para locação deve ser menor ou igual a quantidade disponivel para locação;
			if ( $qtdParaLocacao <= $qtdDisponivelParaLocacao ) {
				return true;
			}			
		} 						
				
		return false;
	}
	
	public function geraDatasLocacaoDevolucao( $request ){	
								
		$dataLocacao = new DateTime(date("Y-m-d"));
		$dataDevolucao = new DateTime(date("Y-m-d"));

		$dataDevolucao->modify("+".$this->parametros->PRAZO_DEVOLUCAO." days");	
						
		//se o prazo tiver caido no sabado ou domingo, incrementa pra cair em um dia útil;		
		while( $dataDevolucao->format("w") == 0 /* Domingo */ || $dataDevolucao->format("w") == 6 /* Sábado */ ) {
			$dataDevolucao->modify("+1 day");		
		}
		
		//carrega as informações das datas de locação e devolução no request para criação da locação;
		$request->merge( array( 'data_locacao' => $dataLocacao->format("Y-m-d") ));	
		$request->merge( array( 'data_devolucao' => $dataDevolucao->format("Y-m-d") ));

		return $request;
	}

}
