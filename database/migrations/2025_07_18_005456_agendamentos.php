<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beneficiario_id')->constrained('beneficiarios')->onDelete('restrict');
            $table->foreignId('profissional_id')->constrained('profissionais')->onDelete('restrict');
            $table->foreignId('area_atendimento_id')->constrained('areas_atuacao')->onDelete('restrict');
            $table->dateTime('data_hora_agendamento');
            $table->string('hora_registro');
            $table->text('observacoes_agendamento')->nullable();
            $table->string('status_agendamento', 50);
            $table->enum('agendamento', ['Agendado', 'Confirmado', 'Cancelado', 'Realizado'])
                ->default('Agendado');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendamentos');
    }
};
