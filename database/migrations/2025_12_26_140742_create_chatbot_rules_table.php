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
        Schema::create('chatbot_rules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('whatsapp_setup_id'); // Link to WhatsAppSetup
            $table->unsignedBigInteger('created_by_id'); // Admin/User who created the rule
            $table->string('trigger_type')->default('contains'); // exact, contains, starts_with, default
            $table->string('trigger_value')->nullable(); // hi, price, hello etc
            $table->text('reply_message'); // Bot reply
            $table->boolean('is_active')->default(1); // Active/Inactive
            $table->integer('priority')->default(1); // Rule priority
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('whatsapp_setup_id')
                  ->references('id')
                  ->on('whats_app_setups')
                  ->onDelete('cascade');

            $table->foreign('created_by_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbot_rules');
    }
};
