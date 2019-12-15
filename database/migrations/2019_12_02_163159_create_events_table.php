<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedInteger('user_id');
            $table->string('slug')->unique()->nullable();
            $table->text('desc');
            $table->string('strtdt');
            $table->string('strttm');
            $table->string('enddt');
            $table->string('endtm');
            $table->string('location');
            $table->string('venue');
            $table->unsignedInteger('topic_id');
            $table->unsignedInteger('price');
            $table->unsignedInteger('qty');
            $table->string('image_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
