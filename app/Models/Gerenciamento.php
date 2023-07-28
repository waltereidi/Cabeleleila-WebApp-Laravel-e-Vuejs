<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; 

class Gerenciamento extends Model
{
    use HasFactory;

    public function gerenciamentosGraficoRendaMensal(){

        return DB::select(
            <<<SQL
            select to_char(a.dataagendamento ,'DD/MM/YYYY') as labels , count( a.id) as values 
            from public.agendamentos a
            where a.dataagendamento >= (current_date-interval '1 month')
            group by to_char(a.dataagendamento ,'DD/MM/YYYY') 
            order by to_char(a.dataagendamento ,'DD/MM/YYYY')  desc 
            SQL
        );

    }
    public function getGraficoAgendamentosMensalBusca( $parametros ){
        if($parametros['mesanoInicio'] != null ){
            $query = "where a.dataagendamento between '01-".substr( $parametros['mesanoInicio'] , 5 , 7 ).'-'.substr($parametros['mesanoInicio'] ,0 , 4 )."' and ";
            
            if($parametros['mesanoFim'] != null ){
                $query .= "'01-".substr( $parametros['mesanoFim'] , 5 , 7 ).'-'.substr($parametros['mesanoFim'] ,0 , 4 )."' ";
            }else{
                $query .= " DATE '01-".substr( $parametros['mesanoInicio'] , 5 , 7 ).'-'.substr($parametros['mesanoInicio'] ,0 , 4 )."'+interval '1 month' ";
            }
        }
        return DB::select(
            <<<SQL
            select to_char(a.dataagendamento ,'DD/MM/YYYY') as labels , count( a.id ) as values 
            from public.agendamentos a
            {$query}
            group by to_char(a.dataagendamento ,'DD/MM/YYYY') 
            order by to_char(a.dataagendamento ,'DD/MM/YYYY')  desc 
            SQL
        );
    }
    
    public function getGraficoArrecadamentosMensalBusca( $parametros ){
        if($parametros['mesanoInicio'] != null ){
            $query = "where a.dataagendamento between '01-".substr( $parametros['mesanoInicio'] , 5 , 7 ).'-'.substr($parametros['mesanoInicio'] ,0 , 4 )."' and ";
            
            if($parametros['mesanoFim'] != null ){
                $query .= "'01-".substr( $parametros['mesanoFim'] , 5 , 7 ).'-'.substr($parametros['mesanoFim'] ,0 , 4 )."' ";
            }else{
                $query .= " DATE '01-".substr( $parametros['mesanoInicio'] , 5 , 7 ).'-'.substr($parametros['mesanoInicio'] ,0 , 4 )."'+interval '1 month' ";
            }
        }else{
            $query = "where a.dataagendamento >= (current_date-interval '1 month')";
        }
        return DB::select(
            <<<SQL
            select to_char(a.dataagendamento ,'DD/MM/YYYY') as labels , sum( s.preco ) as values 
            from public.agendamentos a
            join public.agendamentoservicos ags on ags.agendamentos_id = a.id 
            join public.servicos s on s.id = ags.servicos_id
            {$query}
            group by to_char(a.dataagendamento ,'DD/MM/YYYY') 
            order by to_char(a.dataagendamento ,'DD/MM/YYYY')  desc 
            SQL
        );
    }
}
