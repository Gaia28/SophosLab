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
    Schema::create('produto_material', function (Blueprint $table) {
        $table->id();
        
        $table->foreignId('produto_id')->constrained('produtos')->onDelete('cascade');
        $table->foreignId('material_id')->constrained('materials')->onDelete('cascade');
        
        $table->decimal('quantidade_uso', 10, 2);
        
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produto_material');
    }
};
