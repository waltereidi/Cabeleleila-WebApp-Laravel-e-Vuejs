<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Usuarios;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function postLogin(Request $request ){
        $regras = [
            'email' => 'required|max:60' , 
            'senha' => 'required|max:30',
        ];
        $mensagems= [
            'email.max:60' => 'O limite de caracteres do campo email é 60' , 
            'senha.max:30' => 'O limite de caracteres do campo senha é 30' 
        ];
        $dados =[ 
            'email' => $request->email ,
            'senha' => $request->senha
        ];
        $validar = Validator::make( $dados , $regras , $mensagems);

        if($validar->fails()){
                return Redirect::to('login')->with('mensagem' , $validar->errors() );
        }else{
            
            $usuarios = Usuarios::where('email' ,$request->email)
                ->where('senha' , $request->senha)
                ->where('status' , 1 )        
                ->first();

            if($usuarios->count() > 0 ){
                session(['email' => $usuarios->email]);
                session(['tipousuario'=> $usuarios->tipousuario] );
                return redirect('/');
            }else{
                return Redirect::to('login')->with('mensagem' , 'Senha ou email incorretos');
            }

        }
    }

    public function postRegistrar(Request $request ){
        $regras = [
            'registrar_email' => 'required|max:60' , 
            'registrar_senha' => 'required|max:30|confirmed',
            'registrar_nome' => 'required|max:120'
        ];
        $mensagems= [
            'email.max:60' => 'O limite de caracteres do campo email é 60' , 
            'senha.max:30' => 'O limite de caracteres do campo senha é 30' ,
            'senha.confirmed'=> 'A senha e a confirmação da senha devem ser iguais'
        ];
        $validar = Validator::make($request , $regras , $mensagems);


        if( $validar->fails() ){
            return Redirect::to('login')->with('mensagem' , $validar->errors() ); 

        }else{
            
            $usuarios = Usuarios::where('email' ,$request->email)->first();
            if( $usuarios->count() > 0 ){
                return Redirect::to('login')->with('mensagem' , 'O email utilizado já possui um cadastro no sistema.');
            }else{
                Usuarios::create([
                    "email" => $request->registrar_email , 
                    "senha" => $request->registrar_senha , 
                    "nome" => $request->registrar_nome ,
                    "created_at" => Carbon::now() 
            ]);

            return redirect('/login');
        }

        }
        
        
    }

    public function logout(){
        if(session()->has('email') && session()->has('tipousuario') ){
            session()->forget('email');
            session()->forget('tipousuario');
            
            return redirect('/');
        }else{
            return redirect('/');
        }

    }
}
