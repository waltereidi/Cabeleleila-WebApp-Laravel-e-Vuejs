<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendamentoServicos extends Model
{
    use HasFactory;
    protected $fillable = ["id" ,"created_at" , "updated_at" , "servicos_id" , "agendamentos_id"];
    protected $table = 'agendamentoservicos';
}
