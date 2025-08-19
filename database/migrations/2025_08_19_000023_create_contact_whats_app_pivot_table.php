<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactWhatsAppPivotTable extends Migration
{
    public function up()
    {
        Schema::create('contact_whats_app', function (Blueprint $table) {
            $table->unsignedBigInteger('whats_app_id');
            $table->foreign('whats_app_id', 'whats_app_id_fk_10691173')->references('id')->on('whats_apps')->onDelete('cascade');
            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id', 'contact_id_fk_10691173')->references('id')->on('contacts')->onDelete('cascade');
        });
    }
}
