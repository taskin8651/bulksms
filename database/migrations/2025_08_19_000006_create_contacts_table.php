<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->integer('phone_number')->nullable();
            $table->integer('whatsapp_number')->nullable();
            $table->string('status')->nullable();
            $table->string('organization')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
