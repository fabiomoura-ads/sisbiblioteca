<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use App\Editora;

class EditoraController extends Controller
{
    protected $editora;
	protected $CLASS_NAME = "Editora";

    public function __construct(Editora $editora){
    	$this->editora = $editora;
    }

    public function index(){
    	return $this->editora->all();
    }

    public function store(Request $request){
    	
    	$validator = Validator::make(
    		$request->all(),
    		[
    			'name' => 'required',
    			'email' => 'email|unique:editoras'
    		]

    	);

    	if(!$validator->fails()){
    		$editora = $this->editora->create($request->all());
			return $this->getMessageReturn("success", "adicionada com sucesso", $editora->nome );
    	}
		return $this->getMessageReturn("error", "não adicionada, verifique!.", null );
    }


    public function show($id){
    	return $this->editora->find($id);
    }

    public function update(Request $request, $id){
		
		$validator = Validator::make(
    		$request->all(),
    		[
    			'name' => 'required',    
    			'email' => 'email|unique:editoras'.$id
    		]
    	);

    	if(!$validator->fails()){
    		$editora = $this->editora->update($request->all());
			return $this->getMessageReturn("success", "atualizada com sucesso", $editora->nome );
    	}

		return $this->getMessageReturn("error", "não foi atualizada, verifique!", null );
    }

    public function destroy($id){
    	$editoras = $this->editora->find($id);
    	if($editoras->delete()){
    		return $this->getMessageReturn("success", "deletada com sucesso!", $editora->nome );
    	}

		return $this->getMessageReturn("error", "não foi deletada, verifique!", null );
    }
}
	