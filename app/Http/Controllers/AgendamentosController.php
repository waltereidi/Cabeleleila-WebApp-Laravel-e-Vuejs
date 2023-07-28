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
            $dataAgendamento = Carbon::parse($request->dataagendamento);
            

            $agendamento = Agendamentos::where('clientes_id' , $request->clientes_id )
            ->where('dataagendamento' , '>=' ,$dataAgendamento->startOfWeek())
            ->select('dataagendamento')
            ->orderBy('dataagendamento' , 'desc')->first();

            if( $agendamento!=null && $agendamento->count() > 0  && $agendamento['dataagendamento'] <= $dataAgendamento->endOfWeek()){
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
        $dbrawCasesituacao = "case agendamentos.situacaoagendamento ".
            "when 1 then  'Ativo' ".
            "when 2 then 'Em andamento' ".
            "when 9 then 'Finalizado' ".
            "when 10 then 'Cancelado' ".            
            "end as situacao ";


        $agendamentos =DB::table('agendamentos')
            ->join('clientes' , 'clientes.id' , '=' ,  'agendamentos.clientes_id') 
            ->join('usuarios' , 'usuarios.id' , '=' , 'agendamentos.usuarios_id') 
            ->join('agendamentoservicos' , 'agendamentoservicos.agendamentos_id' , '=' , 'agendamentos.id' )
            ->join('servicos' , 'servicos.id' , '=' , 'agendamentoservicos.servicos_id')
            ->distinct('agendamentoservicos.agendamentos_id')
            ->select('agendamentos.id', 'agendamentos.descricao' , 
            DB::raw($dbrawCasesituacao) , 'usuarios.nome as usuariosnome' ,'clientes.nome as clientesnome' ,
            DB::raw('SUM(servicos.preco) over(partition by agendamentos.id) as preco ') )
            ->limit(50)->get();

            return $agendamentos;

    }
    public function getAgendamentosPaginacao(Request $request){
        $parametros = $request->all(); 
        $dbrawCasesituacao = "case agendamentos.situacaoagendamento ".
            "when 1 then  'Ativo' ".
            "when 2 then 'Em andamento' ".
            "when 9 then 'Finalizado' ".
            "when 10 then 'Cancelado' ".            
            "end as situacao ";

        $agendamentos =DB::table('agendamentos')
            ->join('clientes' , 'clientes.id' , '=' ,  'agendamentos.clientes_id') 
            ->join('usuarios' , 'usuarios.id' , '=' , 'agendamentos.usuarios_id') 
            ->join('agendamentoservicos' , 'agendamentoservicos.agendamentos_id' , '=' , 'agendamentos.id' )
            ->join('servicos' , 'servicos.id' , '=' , 'agendamentoservicos.servicos_id')
            ->distinct('agendamentoservicos.agendamentos_id')
            ->select('agendamentos.id', 'agendamentos.descricao' , 
            DB::raw($dbrawCasesituacao) , 'usuarios.nome as usuariosnome' ,'clientes.nome as clientesnome' ,
            DB::raw('SUM(servicos.preco) over(partition by agendamentos.id) as preco ') )
            ->skip($parametros['inicio'])->limit(50)->get();

            return $agendamentos;
    }
    public function getTipoSituacao(string $situacao){
        switch(strtolower($situacao)){
            case 'ativo' : return 1 ;break ;
            case 'em andamento' : return 2 ;break ; 
            case 'finalizado' : return 9 ;break ; 
            case 'cancelado' :return 10 ;break ; 
            default : return null ;break ;
        }
    }

    public function getBuscaAgendamentos(Request $request){
        $parametros = $request->all(); 

        $dbrawCasesituacao = "case agendamentos.situacaoagendamento ".
            "when 1 then  'Ativo' ".
            "when 2 then 'Em andamento' ".
            "when 9 then 'Finalizado' ".
            "when 10 then 'Cancelado' ".           
            "end as situacao ";
        
        $busca = $parametros['busca'];

        switch(strtolower($parametros['coluna']) ){
            case 'descricao' : $query = "where descricao ilike '%{$busca}%'";  break;
            case 'id' : $query = "where id = '{$busca}'" ;  break;
            case 'preco' : $query = "where preco = '{$busca}'"; break;
            case 'dataagendamento' : $query = "where dataagendamento = '{$busca}'";  break;
            case 'situacaoagendamento' : $query = "where situaca = '{getBuscaAgendamentos($busca)}'"; break;
            case 'clientes_id' : $query = "where clientesnome ilike '%{$busca}%'";  break;
            case 'usuarios_id' : $query = "where usuariosnome ilike '%{$busca}%'";  break;
            default : null ;
        };
        
        $agendamentos = DB::select(
                <<<SQL
                with getAgendamentos as (
                select 
                distinct 
                a.id as id , a.descricao as descricao , a.dataagendamento  as dataagendamento  , 
                case a.situacaoagendamento 
                when 1 then 'Ativo' 
                when 2 then 'Em andamento' 
                when 9 then 'Finalizado' 
                when 10 then 'Cancelado' end as situacao , 
                u.nome as usuariosnome , 
                cl.nome as clientesnome , 
                sum(s.preco) over ( partition by a.id ) as preco
                from public.agendamentos a 
                join public.clientes cl on cl.id = a.clientes_id  
                join public.usuarios u  on u.id = a.usuarios_id  
                join public.agendamentoservicos ags on ags.agendamentos_id  = a.id  
                join public.servicos s  on s.id  = ags.servicos_id 
                )
                select * from getAgendamentos
                {$query}
                SQL);
                return $agendamentos;

    }

    public function editarAgendamentos(Request $request ){

        return view('editarAgendamentos');


    }

}
