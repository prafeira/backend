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
        Schema::create('pessoa', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->integer('cpf');
            $table->integer('funcao_id');
            $table->integer('comissao');
            $table->string('telefone');
            $table->date('data_admissao');
            $table->date('data_desligamento')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('empresa_id');
            $table->string('name');
            $table->string('email', 191)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreign('empresa_id')->references('id')->on('empresa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pessoa');
    }
};
