<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsSetupsTable extends Migration
{
    public function up()
    {
        Schema::create('sms_setups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
