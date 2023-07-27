<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Servicos;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon; 

class ServicosController extends Controller
{
    public function Index(){
        if(session()->has('email') && session()->has('tipousuario') ){
            return view('servicos') ; 

        }else{
            return view('login');      
        }
    }

    
    public function cadastrarServicos(Request $request ){

        $regras = [
            'nome' => 'required|max:60',
            'preco' => 'required', 
            'tempoestimado' => 'required', 
            'descricao' => 'max:255'
        ];
        $mensagems= [
            'nome.max:60'=> 'Limite de tamanho maximo "60" ',
            'nome.required' => 'preencher campo nome é obrigatorio', 
            'preco.required' => 'o campo preco deve estar preenchido" ', 
            'tempoestimado.required'=> 'O campo tempo estimado deve estar preenchido ', 
            'descricao.max:255' => 'Limite de tamanho maximo "255" '
        ];
        $dados =[ 
            'nome' => $request->nome,
            'preco' => $request->preco ,
            'tempoestimado' => $request->tempoestimado,
            'descricao' => $request->descricao
        ];

        $validar = Validator::make( $dados , $regras , $mensagems);
        if($validar->fails()){
            return Redirect::to('servicos')->with('mensagem' , $validar->errors() ); 
        }else{
                Servicos::create([
                    'nome' => $request->nome , 
                    'preco' => $request->preco ,
                    'temoestimado' => $request->tempoestimado , 
                    'descricao' => $request->descricao , 
                    'created_at' => Carbon::now() 
            ]);
            return redirect('/servicos');
        }

        }


        public function modificarServicos(Request $request) { 

            $regras = [
                'nome' => 'required|max:60',
                'preco' => 'required', 
                'tempoestimado' => 'required', 
                'descricao' => 'max:255'
            ];
            $mensagems= [
                'nome.max:60'=> 'Limite de tamanho maximo "60" ',
                'nome.required' => 'preencher campo nome é obrigatorio', 
                'preco.required' => 'o campo preco deve estar preenchido" ', 
                'tempoestimado.required'=> 'O campo tempo estimado deve estar preenchido ', 
                'descricao.max:255' => 'Limite de tamanho maximo "255" '
            ];
            $dados =[ 
                'nome' => $request->nome,
                'preco' => $request->preco ,
                'tempoestimado' => $request->tempoestimado,
                'descricao' => $request->descricao
            ];
    
            $validar = Validator::make( $dados , $regras , $mensagems);
            if($validar->fails()){
                return Redirect::to('servicos')->with('mensagem' , $validar->errors() ); 
            }else{

                $servico = Servicos::find($request->id); 
                if(!$servico){
                    return response()->json(['message' => '401']);

                }else{
                    $servico->update($request->all());
                    return response()->json(['message' => '201']);
                }

                return redirect('/servicos');
            }

        }

        public function deletarServicos($id) {
            $servico = Servicos::find($id);
            if($servico ){
                $servico->delete();
                return response()->json(['mensagem'=>'OK']);
    
            }else{
                return response()->json(['mensagem'=>'401']);
            }
        }
    
}
