<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('beneficiarios', function (Blueprint $table) {
            $table->id();

            // Dados pessoais
            $table->string('nome');
            $table->date('data_nascimento');
            $table->string('cpf', 14)->unique();
            $table->string('telefone', 20)->nullable();

            // Relacionamento com endereço
            $table->foreignId('endereco_id')->nullable()->constrained('enderecos');

            // Escolaridade e cadastro
            $table->string('escolaridade')->nullable();
            $table->string('cadunico')->nullable()->comment('Número do CadÚnico');

            // Limitações
            $table->json('limitacoes')->nullable();
            $table->string('outras_limitacoes')->nullable();

            // Status e controle
            $table->enum('status', ['ativo', 'inativo', 'pendente'])->default('pendente');
            $table->text('observacoes')->nullable();

            // Timestamps
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('cpf');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beneficiarios');
    }
};
