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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nome');
            $table->string('email')->nullable()->unique();
            $table->string('cpf')->nullable()->unique();
            $table->string('rg')->nullable()->unique();
            $table->string('telefone');
            $table->string('telefone2')->nullable();
            $table->string('observacao')->nullable();
            $table->datetime('datanascimento')->nullable();

        });
        DB::table('clientes')->insert(     
        array([
            'nome'=> 'Ray Dalio',
            'email' => 'raydalio@bridgewater.com',
            'telefone'=> '14997289932' 
        ],[
            'nome'=> 'Thomas. L Friedman',
            'email' => 'thomas@worldisflat.com',
            'telefone'=> '14997289932' 
        ],[
            'nome'=> 'William Rosen',
            'email' => 'William@amazon.com',
            'telefone'=> '31 99240 2333' 
        ],
        [
            'nome'=> 'Matthew Walker',
            'email' => 'matthew@amazon.com',
            'telefone'=> '80 99740 2593' 
        ],
        [
            'nome'=> 'Yuval Harari',
            'email' => 'yuval@amazon.com',
            'telefone'=> '44 99040 8593' 
        ], 
        [
            'nome'=> 'Joshua Foer',
            'email' => 'Joshua@amazon.com',
            'telefone'=> '92 98120 1048' 
        ]
    ),
        
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
