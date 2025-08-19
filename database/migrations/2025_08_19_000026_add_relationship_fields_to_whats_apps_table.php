<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToWhatsAppsTable extends Migration
{
    public function up()
    {
        Schema::table('whats_apps', function (Blueprint $table) {
            $table->unsignedBigInteger('template_id')->nullable();
            $table->foreign('template_id', 'template_fk_10691172')->references('id')->on('whats_app_templates');
        });
    }
}
