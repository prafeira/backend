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
        Schema::create('venda', function (Blueprint $table) {
            $table->id();
            $table->integer('valor');
            $table->integer('forma_pagamento_id');
            $table->integer('situacao_pagamento');
            $table->date('data_registro')->nullable();
            $table->unsignedBigInteger('pessoa_id');
            $table->unsignedBigInteger('empresa_id');
            $table->integer('desconto');
            $table->foreign('empresa_id')->references('id')->on('empresa');
            $table->foreign('pessoa_id')->references('id')->on('pessoa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venda');
    }
};
