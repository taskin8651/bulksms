<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('whatsapp_message_logs', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('whatsapp_id')->nullable(); // campaign
        $table->unsignedBigInteger('contact_id')->nullable();  // user/contact
        
        $table->string('message_id')->nullable(); // Meta message ID
        $table->longText('message')->nullable();
        $table->string('status')->default('pending'); 
        // pending, sent, delivered, read, failed

        $table->string('error_message')->nullable();
        $table->json('response_payload')->nullable();

        $table->timestamps();
        $table->softDeletes();

        $table->foreign('whatsapp_id')->references('id')->on('whats_apps')->onDelete('cascade');
        $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_message_logs');
    }
};
