<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Aluno;
use Validator;

class AlunoController extends Controller
{
	protected $context;
	protected $CLASS_NAME = "Aluno";
	
	public function __construct(Aluno $context){
		$this->context = $context;
	}
	
    public function index(){
		$op = "S";
		$result = $this->context->all();
		return $this->getMessageReturn($result, $op, null, null);
    }
    
    public function store(Request $request) {
		$op = "I";
		
        $validator = Validator::make(
			$request->all(),
			[
				'matricula' => 'required|unique:alunos',
				'nome' => 'required|max:150',
				'email' => 'required'
			]
		);
		
		if ( $validator->fails() ) {
			return $validator->errors();
		}
		
		$result = $this->context->create($request->all());		
		return $this->getMessageReturn($result, $op, null, null);
    }

    public function show($id) {
		$op = "S";		
		$result = $this->context->find($id);
		return $this->getMessageReturn($result, $op);
		
    }

    public function update(Request $request, $id) {
		$op = "U";
		
        $validator = Validator::make(
			$request->all(),
			[
				'matricula' => 'required|unique:alunos,matricula,'.$id,
				'nome' => 'required|max:150',
				'email' => 'required'
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
     * Método para consultar somente os alunos ativos.
	 * Alunos ativos possuem status = 1
     * @return \Illuminate\Http\Response
     **/
    public function active() {
		$op = "S";		
		$result = $this->context->active()->get();		
		return $this->getMessageReturn($result, $op, null, null);					
    }	
	
}
