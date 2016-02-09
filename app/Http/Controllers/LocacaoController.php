<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Locacao;
use App\Livro;
use App\Aluno;
use Validator;

class LocacaoController extends Controller
{
	protected $context;
	protected $CLASS_NAME = "Locacao";
	
	public function __construct(Locacao $context){
		$this->context = $context;
	}
	
    public function index(){
		$op = "S";		
		$result = $this->context->with('alunos')->with('livros')->get();
		return $this->getMessageReturn($result, $op);
    }
    
    public function store(Request $request){
		$op = "I";
		
        $validator = Validator::make(
			$request->all(),
			[
				'aluno_id' => 'required',
				'livro_id' => 'required',
				'data_locacao' => 'required',
				'data_devolucao' => 'required'
			]
		);
				
		if ( $validator->fails() ) {
			return $validator->errors();
		}
		
		$result = $this->context->create($request->all());
		return $this->getMessageReturn($result, $op);
    }

    public function show($id) {
		$op = "S";
		$result = $this->context->with('alunos')->with('livros')->find($id);
		return $this->getMessageReturn($result, $op);
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
		return $this->getMessageReturn($result, $op);
    }
	
    public function destroy($id) {
		$op = "D";
		
		$result = $this->context->find($id);
		if ( $result ) {
			$result = $result->delete();	
		}				
		return $this->getMessageReturn($result, $op);		
    }
}
