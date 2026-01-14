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
    Schema::table('item_vendas', function (Blueprint $table) {
        // 1. Criar coluna para salvar o nome fixo (Snapshot)
        $table->string('nome_produto')->after('produto_id')->nullable();

        // 2. Modificar o ID para aceitar nulo
        $table->unsignedBigInteger('produto_id')->nullable()->change();

        // 3. Mudar a regra: Se apagar o produto, define o ID como NULL (em vez de apagar a venda)
        $table->dropForeign(['produto_id']);
        
        $table->foreign('produto_id')
              ->references('id')
              ->on('produtos')
              ->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_vendas', function (Blueprint $table) {
            //
        });
    }
};
