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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	protected $context;
	protected $CLASS_NAME = "Locacao";
	
	public function __construct(Locacao $context){
		$this->context = $context;
	}
	
    public function index(){
		
		$result = $this->context->with('alunos')->with('livros')->get();
		
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
		
		if ( $result ) {
			return $this->getMessageReturn("success", "inserida com sucesso!", $result, null );			
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
		
		$result = $this->context->with('alunos')->with('livros')->find($id);
		
		if ( $result ) {
			return $this->getMessageReturn("success", "localizado", $result, null);			
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
		
		if ( $result->update($request->all()) ) {
			return $this->getMessageReturn("success", "atualizado com sucesso!", null, null );			
		} 
		
		return $this->getMessageReturn("error", "não foi atualizado, verifique!", null, null );	
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
			
			if ( $result->delete() ){ 
				return $this->getMessageReturn("success", "excluído com sucesso!", null, null);			
			} 
			
			return $this->getMessageReturn("error", "não foi possível excluir, verifique!", null, $id);			
		}
		
		return $this->getMessageReturn("error", "não foi localizado!", null, $id);	
		
    }
}
