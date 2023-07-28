<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Agendamentos extends Model
{
    use HasFactory;
    protected $fillable = ["id","dataagendamento","datatermino","descricao","observacao","situacaoagendamento","desconto","acrescimo","usuarios_id" , "clientes_id"];

    public function getBuscaAgendamentos($parametros){
        
       
        $busca = $parametros['busca'];

        switch(strtolower($parametros['coluna']) ){
            case 'descricao' : $query = "where descricao ilike '%{$busca}%'";  break;
            case 'id' : $query = "where id = '{$busca}'" ;  break;
            case 'preco' : $query = "where preco = '{$busca}'"; break;
            case 'dataagendamento' : $query = "where dataagendamento = '{$busca}'";  break;
            case 'situacaoagendamento' : $query = "where lower(situacao) = '{$busca}'"; break;
            case 'clientes_id' : $query = "where clientesnome ilike '%{$busca}%'";  break;
            case 'usuarios_id' : $query = "where usuariosnome ilike '%{$busca}%'";  break;
            default : null ;
        };
        
        return DB::select(
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
                

    }

    public function getAgendamentosPaginacao($parametros){
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

}
