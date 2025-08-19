<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailSetupsTable extends Migration
{
    public function up()
    {
        Schema::create('email_setups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('provider_name');
            $table->string('from_name')->nullable();
            $table->string('from_email');
            $table->string('host')->nullable();
            $table->string('port')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('encryption')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
