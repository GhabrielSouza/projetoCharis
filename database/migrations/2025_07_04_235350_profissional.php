<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profissionais', function (Blueprint $table) {
            $table->id();

            // Dados pessoais
            $table->string('nome_completo');
            $table->date('data_nascimento');
            $table->string('cpf', 14)->unique();
            $table->string('telefone', 20);
            $table->string('email')->nullable();

            // Dados profissionais
            $table->string('numero_registro')->comment('CRM/COREN etc');
            $table->string('area_atuacao');
            $table->enum('perfil', ['Médico', 'Enfermeiro', 'Psicólogo', 'Assistente Social', 'Outro']);

            // Status e controle
            $table->enum('status', ['ativo', 'inativo'])->default('ativo');
            $table->text('observacoes')->nullable();

            // Timestamps
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('numero_registro');
            $table->index('status');
            $table->index('perfil');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profissionais');
    }
};
