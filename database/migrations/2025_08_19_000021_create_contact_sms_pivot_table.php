<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactSmsPivotTable extends Migration
{
    public function up()
    {
        Schema::create('contact_sms', function (Blueprint $table) {
            $table->unsignedBigInteger('sms_id');
            $table->foreign('sms_id', 'sms_id_fk_10691140')->references('id')->on('smss')->onDelete('cascade');
            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id', 'contact_id_fk_10691140')->references('id')->on('contacts')->onDelete('cascade');
        });
    }
}
