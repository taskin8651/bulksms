<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSmssTable extends Migration
{
    public function up()
    {
        Schema::table('smss', function (Blueprint $table) {
            $table->unsignedBigInteger('template_id')->nullable();
            $table->foreign('template_id', 'template_fk_10691139')->references('id')->on('sms_templates');
        });
    }
}
