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
        Schema::create('agendamentoservicos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('servicos_id')->unsigned();
            $table->foreign('servicos_id')
                ->references('id')->on('servicos');
            
            $table->integer('agendamentos_id')->unsigned();
            $table->foreign('agendamentos_id')
                ->references('id')->on('agendamentos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendamentoservicos');
    }
};
