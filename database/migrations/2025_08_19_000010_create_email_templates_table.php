<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailTemplatesTable extends Migration
{
    public function up()
    {
        Schema::create('email_templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('template_name');
            $table->string('subject');
            $table->longText('body');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
