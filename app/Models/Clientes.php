<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Clientes extends Model
{
    use HasFactory;
    protected $fillable = ["email","nome","cpf","rg","telefone","telefone2","datanascimento","observacao","created_at"];
 
}
