<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Clientes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon; 

class ClientesController extends Controller
{
    public function Index(){
        if(session()->has('email') && session()->has('tipousuario') ){
            return view('clientes') ; 

        }else{
            return view('login');      
        }
    }

    public function deletarClientes($id) {
        
        $cliente = Clientes::find($id);
        if($cliente ){
            $cliente->delete();
            return response()->json(['mensagem'=>'OK']);

        }else{
            return response()->json(['mensagem'=>'401']);
        }
    }

    public function cadastrarClientes(Request $request ){

        $regras = [
            'id' => 'required' ,
            'email' => 'max:60' , 
            'nome' => 'required|max:60',
            'cpf' => 'max:15', 
            'rg' => 'max:15', 
            'telefone' => 'required|max:15', 
            'telefone2' => 'max:15', 
            'observacao' => 'max:255'
        ];
        $mensagems= [
            'id.required' =>'Id nao esta sendo enviado' ,
            'email.max:60' => 'Limite de tamanho maximo "60" ', 
            'nome.max:30'=> 'Limite de tamanho maximo "60" ',
            'nome.required' => 'preencher campo nome é obrigatório', 
            'cpf.max:15'=> 'Limite de tamanho maximo "15" ', 
            'rg.max:15'=> 'Limite de tamanho maximo "15" ', 
            'telefone.max:15'=> 'Limite de tamanho maximo "15" ', 
            'telefone.required' => 'Deve haver ao menos um telefone cadastrado" ', 
            'telefone2.max:15'=> 'Limite de tamanho maximo "15" ', 
            'observacao.max:255' => 'Limite de tamanho maximo "255" '
        ];
        $dados =[ 
            'id' => $request->id , 
            'email' => $request->email,
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'rg' => $request->rg,
            'telefone' => $request->telefone,
            'telefone2' => $request->telefone2,
            'datanascimento' => $request->datanascimento,
            'observacao' => $request->observacao
        ];
        $validar = Validator::make( $dados , $regras , $mensagems);
        if($validar->fails()){
            return Redirect::to('clientes')->with('mensagem' , $validar->errors() ); 
        }else{
            
                Clientes::create([
                    "email" => $request->email , 
                    "nome" => $request->nome , 
                    "cpf" => $request->cpf ,
                    "rg" => $request->rg , 
                    "telefone" => $request->telefone, 
                    "telefone2" => $request->telefone2 ,
                    "datanascimento" => $request->datanascimento , 
                    "observacao" => $request->observacao , 
                    "created_at" => Carbon::now() 
            ]);
            return redirect('/clientes');
        }

        }

        public function modificarClientes(Request $request) {
            $regras = [
                'id' => 'required' , 
                'email' => 'max:60' , 
                'nome' => 'required|max:30',
                'cpf' => 'max:15', 
                'rg' => 'max:15', 
                'telefone' => 'required|max:15', 
                'telefone2' => 'max:15', 
                'observacao' => 'max:255'
            ];
            $mensagems= [
                'id.required' => 'id nao esta sendo enviado' , 
                'email.max:60' => 'Limite de tamanho maximo "60" ', 
                'nome.max:30'=> 'Limite de tamanho maximo "30" ',
                'nome.required' => 'preencher campo nome é obrigatório', 
                'cpf.max:15'=> 'Limite de tamanho maximo "15" ', 
                'rg.max:15'=> 'Limite de tamanho maximo "15" ', 
                'telefone.max:15'=> 'Limite de tamanho maximo "15" ', 
                'telefone.required' => 'Deve haver ao menos um telefone cadastrado" ', 
                'telefone2.max:15'=> 'Limite de tamanho maximo "15" ', 
                'observacao.max:255' => 'Limite de tamanho maximo "255" '
            ];
            $dados =[ 
                'id' => $request->id , 
                'email' => $request->email,
                'nome' => $request->nome,
                'cpf' => $request->cpf,
                'rg' => $request->rg,
                'telefone' => $request->telefone,
                'telefone2' => $request->telefone2,
                'datanascimento' => $request->datanascimento,
                'observacao' => $request->observacao
            ];
            $validar = Validator::make( $dados , $regras , $mensagems);
            if($validar->fails()){
                return Redirect::to('clientes')->with('mensagem' , $validar->errors() );  
            }else{
                $cliente = Clientes::find($request->id);
                if(!$cliente ){
                    return response()->json(['message' => '401' ]);

                }else{
                    $cliente->update($request->all()); 
                    return response()->json(['message' , '201']);

                }

            }

        }

        }

