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
        Schema::create('servicos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nome');
            $table->string('descricao')->nullable();
            $table->decimal('preco');
            $table->time('tempoestimado')->default('00:00:00');
            
        });

        DB::table('servicos')->insert(
            array([
                'nome'=>'Corte masculino simples', 
                'descricao'=> '' , 
                'preco' => 12.00 ,
                'tempoestimado'=>'00:30:00'
            ],
            [
                'nome'=>'Corte feminino simples', 
                'descricao'=> '' , 
                'preco' => 20.00 ,
                'tempoestimado' => '01:00:00'
            ],
            [
                'nome'=>'Creme de cabelo', 
                'descricao'=> '' , 
                'preco' => 15.00 ,
                'tempoestimado' => '00:30:00'
            ]
            )
            );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicos');
    }
};
