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
        Schema::table('collection_entries', function (Blueprint $table) {
            $table->string('card_name');
            $table->string('card_type_line')->nullable();
            $table->string('card_image_uri')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('collection_entries', function (Blueprint $table) {
            $table->dropColumn(['card_name', 'card_type_line', 'card_image_uri']);
        });
    }
};
