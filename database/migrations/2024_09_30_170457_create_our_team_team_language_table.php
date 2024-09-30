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
        Schema::create('our_team_team_language', function (Blueprint $table) {
            $table->id();
            $table->foreignId('our_team_id')->constrained('our_teams')->cascadeOnDelete();
            $table->unsignedBigInteger('team_language_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('our_team_team_language');
    }
};
