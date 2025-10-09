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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->uuid('scryfall_id')->unique();
            $table->string('name');
            $table->json('colors')->nullable();
            $table->json('color_identity');
            $table->string( 'mana_cost')->nullable(); //string pq vai usar símbolos
            $table->decimal('cmc', 8, 2)->nullable(); //cmc - Custo de Mana Convertido
            $table->string('type_line');
            $table->text('flavor_text')->nullable();
            $table->text('oracle_text')->nullable();
            $table->json('image_urls')->nullable();
            $table->json('prices')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
