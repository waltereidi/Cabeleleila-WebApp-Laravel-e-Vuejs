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
            $table->string('email')->nullable();
            $table->string('cpf')->nullable();
            $table->string('rg')->nullable();
            $table->string('telefone');
            $table->string('telefone2')->nullable();
            $table->string('observacao')->nullable();
            $table->datetime('dataaniversario')->nullable();

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
        ])
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
