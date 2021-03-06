<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Aluno;
use Validator;
use Response;

class AlunoController extends Controller
{
	protected $context;
	
	public function __construct(Aluno $context){
		$this->context = $context;
	}
	
    public function index(){
		return $this->context->all();
    }
    
    public function store(Request $request) {
		
        $validator = Validator::make(
			$request->all(),
			[
				'matricula' => 'required|unique:alunos',
				'nome' => 'required|max:150',
				'email' => 'required'
			]
		);
		
		if ( $validator->fails() ) {
			return response()->json(['error' => [ $validator->errors()->first() ] ], 401);
		}
		
		$result = $this->context->create($request->all());		
		return $result;
    }

    public function show($id) {
		return $this->context->find($id);
    }

    public function update(Request $request, $id) {
        $validator = Validator::make(
			$request->all(),
			[
				'matricula' => 'required|unique:alunos,matricula,'.$id,
				'nome' => 'required|max:150',
				'email' => 'required'
			]
		);
		
		if ( $validator->fails() ) {
			return response()->json(['error' => [ $validator->errors()->first() ] ], 401);
		}
		
		$result = $this->context->find($id);

		if ( $result ){
			$result->update($request->all());			
		}

		return $result;
		
    }

    public function destroy($id) {
		$result = $this->context->find($id);	
		if ( $result ) {
			$result->delete();	
		}				
		return $result;
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
