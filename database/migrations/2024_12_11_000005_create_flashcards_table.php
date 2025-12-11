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
        Schema::create('flashcards', function (Blueprint $table) {
            $table->id('flashcard_id');
            $table->unsignedBigInteger('collection_id');
            $table->text('front');
            $table->text('back');
            $table->text('hint')->nullable();
            $table->text('explaination')->nullable();
            $table->timestamps();

            $table->foreign('collection_id')->references('collection_id')->on('collections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flashcards');
    }
};
