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
            $table->integer('qtd')->default(0);
            $table->decimal('desconto')->default(0);
            $table->decimal('acrecimo')->default(0);

            $table->integer('servico_id')->unsigned();
            $table->foreign('servico_id')
                ->references('id')->on('servicos');
            
            $table->integer('agendamento_id')->unsigned();
            $table->foreign('agendamento_id')
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
