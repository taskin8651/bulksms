<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEmailsTable extends Migration
{
    public function up()
    {
        Schema::table('emails', function (Blueprint $table) {
            $table->unsignedBigInteger('template_id')->nullable();
            $table->foreign('template_id', 'template_fk_10691146')->references('id')->on('email_templates');
        });
    }
}
