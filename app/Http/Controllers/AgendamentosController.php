<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Agendamentos;
use App\Models\Usuarios ;
use App\Models\AgendamentoServicos;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 

class AgendamentosController extends Controller
{
    public function Index(){
        if(session()->has('email') && session()->has('tipousuario') ){
            return view('agendamentos') ; 

        }else{
            return view('login');      
        }
    }

    public function getAgendamentosSemana(Request $request ){
       
        $regras = [
            'clientes_id' => 'required',
            'dataagendamento' => 'required', 
        ];
        $mensagems= [
            'clinetes_id.required'=> 'O cliente campo cliente deve estar preenchido ',
            'dataagendamento.required' => 'preencher campo data agendamento é obrigatorio', 
        ];
        $dados =[ 
            'clientes_id' => $request->clientes_id,
            'dataagendamento' => $request->dataagendamento 
        ];
        $validar = Validator::make( $dados , $regras , $mensagems);

        if($validar->fails() ){
            return $validar->errors();

        }else{
            date_default_timezone_set('America/Sao_Paulo');
            $dataAgendamento = Carbon::parse($request->dataagendamento)->setTimezone('America/Sao_Paulo');
            
            
            $dataQuery = $request->dataagendamento;
            $idCliente= $request->clientes_id;
            $agendamento = DB::select(
                "select replace(to_char(dataagendamento , 'YYYY-MM-DD HH24:mm'),' ', 'T' ) as dataagendamento ".
                "from public.agendamentos ".
                "where  clientes_id = ".$idCliente." and ".
                "dataagendamento between date_trunc('week' ,DATE'".$dataQuery."') and date_trunc('week' , DATE'".$dataQuery."' )+interval '6 days' ".
                "order by dataagendamento desc limit 1" );
                return $agendamento ;
            if( $agendamento!=null && $agendamento->count() > 0 ){
                return $agendamento;
            }else{
                return response()->json(['OK']);
            }
        }
    }
    public function cadastrarAgendamentos(Request $request ){
        $regras = [
            'servicos' => 'required',
            'clientes_id' => 'required' ,
            'dataagendamento' => 'required|date', 
            'descricao' =>'max:255' ,
            'observacao' => 'max:255' ,
            'desconto' => 'decimal:2' , 
            'acrescimo' => 'decimal:2', 
            'email' => 'required',
        ];
        $mensagems= [
            'servicos.required'=> 'Deve haver ao menos um servico cadastrado ',
            'clientes_id.required' => 'Deve haver ao menos um cliente cadastrado',
            'dataagendamento.required' => 'A data deve estar preenchida' , 
            'dataagendamento.date' => 'formato de data inválido' ,
            'descricao.max:255' => 'A descricao deve conter até 255 caracteres', 
            'observacao.max:255' => 'A observacao deve conter até 255 caracteres', 
            'desconto.decimal:2' => 'O desconto deve ser do tipo numérico com no máximo duas casas decimais ex: 00.00 ' , 
            'acrescimo.decimal:2' => 'O desconto deve ser do tipo numérico com no máximo duas casas decimais ex: 00.00' ,
            'email.required' => 'O email é obrigatório'
        ];
        $dados =[ 
            'servicos' => $request->servicos , 
            'clientes_id' => $request->clientes_id , 
            'dataagendamento' => $request->dataagendamento , 
            'descricao' => $request->descricao , 
            'observacao' => $request->observacao , 
            'desconto' => $request->desconto , 
            'acrescimo' => $request->acrescimo ,
            'email' => $request->email 
        ];
        $validar = Validator::make( $dados , $regras , $mensagems);
        
        if($validar->fails()){
            return response()->json($validar->errors());            

        }else{
            
            DB::beginTransaction();
           
            try{
                $usuario =Usuarios::where('email' ,'=', $request->email )->select('id')->first();
                $agendamento = Agendamentos::create([
                    'clientes_id' => $request->clientes_id ,
                    'dataagendamento' => $request->dataagendamento , 
                    'descricao' => $request->descricao , 
                    'observacao' => $request->observacao , 
                    'desconto' => $request->desconto , 
                    'acrescimo' => $request->acrescimo , 
                    'situacaoagendamento' => 1 , 
                    'usuarios_id' => $usuario['id'],
                    'created_at' => Carbon::now()
                ]);
                
                foreach($request->servicos as $servico ){
                    AgendamentoServicos::create([
                        'created_at' => Carbon::now() , 
                        'servicos_id' => $servico['id'] , 
                        'agendamentos_id' => $agendamento->id
                    ]);
                }

            }catch(\Exception $e ){
                return $e;
                DB::rollBack();
                
            }
            DB::commit();
            return response()->json('OK');
        }

    }

    public function editarAgendamentos(Request $request ){
        $regras = [
            'servicos' => 'required',
            'clientes_id' => 'required' ,
            'dataagendamento' => 'required|date', 
            'descricao' =>'max:255' ,
            'observacao' => 'max:255' ,
            'desconto' => 'decimal:2' , 
            'acrescimo' => 'decimal:2', 
            'email' => 'required',
            'situacaoagendamento'=>'required', 
            'id' => 'required',
        ];
        $mensagems= [
            'servicos.required'=> 'Deve haver ao menos um servico cadastrado ',
            'clientes_id.required' => 'Deve haver ao menos um cliente cadastrado',
            'dataagendamento.required' => 'A data deve estar preenchida' , 
            'dataagendamento.date' => 'formato de data inválido' ,
            'descricao.max:255' => 'A descricao deve conter até 255 caracteres', 
            'observacao.max:255' => 'A observacao deve conter até 255 caracteres', 
            'desconto.decimal:2' => 'O desconto deve ser do tipo numérico com no máximo duas casas decimais ex: 00.00 ' , 
            'acrescimo.decimal:2' => 'O desconto deve ser do tipo numérico com no máximo duas casas decimais ex: 00.00' ,
            'email.required' => 'O email é obrigatório',
            'situacaoagendamento.required' => 'A situação do agendamento é obrigatória' , 
            'id' => 'Id não está sendo enviado na requisição!',
        ];
        $dados =[ 
            'servicos' => $request->servicos , 
            'clientes_id' => $request->clientes_id , 
            'dataagendamento' => $request->dataagendamento , 
            'descricao' => $request->descricao , 
            'observacao' => $request->observacao , 
            'desconto' => $request->desconto , 
            'acrescimo' => $request->acrescimo ,
            'email' => $request->email ,
            'situacaoagendamento' => $request->situacaoagendamento ,
            'id' => $request->id,
        ];
        $validar = Validator::make( $dados , $regras , $mensagems);
        
        if($validar->fails()){
            return response()->json($validar->errors());            

        }else{
            
            DB::beginTransaction();
           

            try{
                $usuario =Usuarios::where('email' ,'=', $request->email )->select('id')->first();
                $dados =[
                    'clientes_id' => $request->clientes_id ,
                        'dataagendamento' => $request->dataagendamento , 
                        'descricao' => $request->descricao , 
                        'observacao' => $request->observacao , 
                        'desconto' => $request->desconto , 
                        'acrescimo' => $request->acrescimo , 
                        'situacaoagendamento' => $request->situacaoagendamento , 
                        'usuarios_id' => $usuario['id'],
                        'updated_at' => Carbon::now() ,
                        'datatermino' => $request->datatermino ,
                        
                    ];
                $agendamento = Agendamentos::find($request->id);
                $agendamento->update($dados); 
                
                $agendamentoServicos = AgendamentoServicos::where('agendamentos_id' , $request->id ); 
                $agendamentoServicos->delete(); 

                foreach($request->servicos as $servico ){
                    AgendamentoServicos::create([
                        'created_at' => Carbon::now() , 
                        'servicos_id' => $servico['id'] , 
                        'agendamentos_id' => $agendamento->id
                    ]);
                }

            }catch(\Exception $e ){
                return $e;
                DB::rollBack();
                
            }
            DB::commit();
            return response()->json('OK');
        }

    }

    public function deletarAgendamento($id) {
        
        $agendamento = Agendamentos::find($id);
        if($agendamento ){
            
            $agendamentoServicos = agendamentoServicos::where('agendamentos_id' , $id) ;
            if($agendamentoServicos){
                $agendamentoServicos->delete();
            }
            $agendamento->delete();
            return response()->json(['mensagem'=>'OK']);

        }else{
            return response()->json(['mensagem'=>'401']);
        }
    }

    public function getAgendamentos() {
        $agendamentos = new Agendamentos();    
        return $agendamentos->getAgendamentos();

    }
    public function getAgendamentosPaginacao(Request $request){
        $agendamentos = new Agendamentos();
        return $agendamentos->getAgendamentosPaginacao( $request->all());
    
    }
  

    public function getBuscaAgendamentos(Request $request){
        $agendamentos = new Agendamentos();
        return $agendamentos->getBuscaAgendamentos($request->all());

    }
    public function getBuscaIntervaloAgendamentos(Request $request){
        $agendamentos = new Agendamentos();
        

   
         
        $parametros = $request->all(); 
        if($parametros['inicio'] == null &&  $parametros['fim'] == null ) {
            return response()->json('Datas invalidas');
        }else{
            return $agendamentos->getBuscaIntervaloAgendamentos($parametros ); 
        }

        

    }
   
    public function getEditarAgendamentos( $id ) {
        $agendamento = Agendamentos::select('id','clientes_id' , 'dataagendamento' , 'descricao' , 'observacao' ,
         'desconto' , 'acrescimo' , 'situacaoagendamento' , 'usuarios_id' ,DB::raw("DATE_PART('day', AGE(NOW(), dataagendamento)) as dias"),
         'datatermino')
        ->where('id' , $id)->first();

        $agendamento->servicos = AgendamentoServicos::select('id' ,'servicos_id')->where('agendamentos_id' , $id)->get() ; 

        return $agendamento;

    }

    
}
