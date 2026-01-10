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
    Schema::create('produtos', function (Blueprint $table) {
        $table->id();
        $table->string('nome');
        $table->text('descricao')->nullable();
        
        $table->decimal('custo_mao_de_obra', 10, 2)->default(0);
        $table->decimal('margem_lucro_percentual', 8, 2)->default(100);
        
        $table->decimal('custo_materiais_total', 10, 2)->default(0);
        $table->decimal('preco_final', 10, 2)->default(0);
        
        $table->integer('estoque_pronto')->default(0); 
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
