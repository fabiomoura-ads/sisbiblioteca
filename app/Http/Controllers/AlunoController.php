<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Aluno;
use Validator;

class AlunoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	protected $context;
	protected $CLASS_NAME = "Aluno";
	
	public function __construct(Aluno $context){
		$this->context = $context;
	}
	
    public function index(){
		$result = $this->context->all();
		if ( $result && !empty($result) && count($result) > 0 ) {
			return $result;
		}
		return $this->getMessageReturn("error", "não possui registros!", null, null );	
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
		
		if ( $result ) {
			return $this->getMessageReturn("success", "inserida com sucesso!", $result, $result["nome"] );			
		} 
		
		return $this->getMessageReturn("error", "não foi inserido, verifique!", null, null );		
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
		
		$result = $this->context->find($id);
		if ( $result ) {
			return $this->getMessageReturn("success", "localizado", $result, $result["nome"]);			
		}
		
		return $this->getMessageReturn("error", "não localizado", null, $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
		
		//return $request;
		
        $validator = Validator::make(
			$request->all(),
			[
				'matricula' => 'required|unique:alunos,matricula,'.$id,
				'nome' => 'required|max:150',
				'email' => 'required',
			]
		);
		
		if ( $validator->fails() ) {
			return $validator->errors();
		}
		
		$result = $this->context->find($id);
		$result = $result->update($request->all());
		
		if ( $result ) {
			return $this->getMessageReturn("success", "atualizado com sucesso!", $result, $result["nome"] );			
		} 
		
		return $this->getMessageReturn("error", "não foi atualizado, verifique!", $result, null );	
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
		
		$result = $this->context->find($id);
		
		if ( $result ) {
			$nome = $result->nome;
			
			if ( $result->delete() ){ 
				return $this->getMessageReturn("success", "excluído com sucesso!", null, $nome);			
			} 
			
			return $this->getMessageReturn("error", "não foi possível excluir, verifique!", null, $id);			
		}
		
		return $this->getMessageReturn("error", "não foi localizado!", null, $id);	
		
    }
}
