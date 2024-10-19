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
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('author_id');
            $table->text('title');
            $table->string('slug')->unique();
            $table->text('short_description');
            $table->longText('description');
            $table->string('feature_image');
            $table->string('alt_text')->nullable();
            $table->enum('status',['1','2','3'])->default('1')->comment('1 = Published, 2 = Draft, 3 = Pending');
            $table->enum('visibility',['1','2'])->default('1')->comment('1 = Public, 2 = Private');
            $table->date('published_date');
            $table->string('meta_title',150)->nullable();
            $table->string('meta_description',180)->nullable();
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
        Schema::dropIfExists('posts');
    }
};
