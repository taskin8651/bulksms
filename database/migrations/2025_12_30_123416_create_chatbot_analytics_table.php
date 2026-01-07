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
       Schema::create('chatbot_analytics', function ($table) {
    $table->id();
    $table->unsignedBigInteger('chatbot_rule_id')->nullable();
    $table->unsignedBigInteger('created_by_id');
    $table->string('user_message');
    $table->string('matched_keyword')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbot_analytics');
    }
};
