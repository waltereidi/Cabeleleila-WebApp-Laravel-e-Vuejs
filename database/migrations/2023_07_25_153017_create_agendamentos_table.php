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
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->datetime('dataagendamento');
            $table->string('descricao')->nullable();
            $table->string('observacao')->nullable();
            $table->integer('situacaoagendamento')->comment('1-ativo ,2-em andamento ,9-finalizado,10-cancelado');
            $table->decimal('desconto')->default(0);
            $table->decimal('acrecimo')->default(0);

            $table->integer('usuarios_id')->unsigned();
            $table->foreign('usuarios_id')->references('id')->on('usuarios');
            
            $table->integer('clientes_id')->unsigned();
            $table->foreign('clientes_id')->references('id')->on('clientes');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendamentos');
    }
};
