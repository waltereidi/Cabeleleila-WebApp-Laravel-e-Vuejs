<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    protected $fillable = ["id" , "created_at" , "updated_at" , "email" , "senha" , "nome" , "tipousuario" , "status"];
    use HasFactory;
}
