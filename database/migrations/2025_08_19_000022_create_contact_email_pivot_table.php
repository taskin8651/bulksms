<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactEmailPivotTable extends Migration
{
    public function up()
    {
        Schema::create('contact_email', function (Blueprint $table) {
            $table->unsignedBigInteger('email_id');
            $table->foreign('email_id', 'email_id_fk_10691147')->references('id')->on('emails')->onDelete('cascade');
            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id', 'contact_id_fk_10691147')->references('id')->on('contacts')->onDelete('cascade');
        });
    }
}
