<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('atendimentos_realizados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beneficiario_id')->constrained('beneficiarios')->onDelete('restrict');
            $table->foreignId('profissional_id')->constrained('profissionais')->onDelete('restrict');
            $table->foreignId('area_atendimento_id')->constrained('areas_atuacao')->onDelete('restrict');
            $table->dateTime('data_hora_atendimento');
            $table->text('descricao_atendimento');
            $table->foreignId('agendamento_origem_id')->nullable()->unique()->constrained('agendamentos')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('atendimentos_realizados');
    }
};
