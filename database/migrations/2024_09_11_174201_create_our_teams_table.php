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
        Schema::create('our_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('specialized_id')->constrained('team_specializeds');
            $table->string('full_name');
            $table->string('position');
            $table->string('experience');
            $table->longText('description');
            $table->string('image');
            $table->string('alt_text')->nullable();
            $table->json('languages');
            $table->enum('status',['1','2','3'])->default('1')->comment('1 = Active, 2 = Inactive');
            $table->string('meta_title',100)->nullable();
            $table->string('meta_description',190)->nullable();
            $table->integer('ordering')->default(0);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('our_teams');
    }
};
