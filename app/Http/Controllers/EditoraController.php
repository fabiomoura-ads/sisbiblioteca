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
    		return ['success' => 'Editora '.$editora->nome. 'adicionada com sucesso'];
    	}
        return ['error' => 'Erro ao adicionar editora.'];
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
    		return ['success' => 'Editora '.$editora->nome. 'atualizada com sucesso'];
    	}
        //return $validator->errors();
        return $request->all();
    }

    public function destroy($id){
    	$editoras = $this->editora->find($id);
    	if($editoras->delete()){
    		return ['success' => 'Editora '.$editoras->id. ' deleta!'];
    	}

    	return ['error' => 'Erro ao deleta categoria '.$editoras->id.'.'];
    }
}
	