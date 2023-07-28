<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('email')->unique();
            $table->string('senha');
            $table->string('nome');
            $table->integer('tipousuario')->default(0)->comment('0 funcionário , 1 gerente');
            $table->integer('status')->default(1)->comment('1-Ativo | 2-Desativado');
        });

        DB::table('usuarios')->insert(
            array(
                ['email' => 'walter-eidi@hotmail.com',
                'senha' => '123' , 
                'nome' => 'Walter Eidi Matsuda' , 
                'tipousuario' => 1 ,
                'status' => 1 ], 
                ['email' => 'admin@dsin.com.br',
                'senha' => 'dsin' , 
                'nome' => 'Duck Dodgers' , 
                'tipousuario' => 1 , 
                'status'=> 1], 
                ['email' => 'leila@cabeleleila.com.br',
                'senha' => 'leila' , 
                'nome' => 'Leila' , 
                'tipousuario' => 1 , 
                'status'=> 1], 
                ['email' => 'nelson@cabeleleila.com.br',
                'senha' => '123' , 
                'nome' => 'Nelson ' , 
                'tipousuario' => 0 , 
                'status'=> 1], 

            )

        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
