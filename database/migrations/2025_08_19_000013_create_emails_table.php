<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsTable extends Migration
{
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('campaign_name');
            $table->string('coins_used')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
