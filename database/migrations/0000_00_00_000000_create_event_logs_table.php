<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class CreateEventLogsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(Config::get('amethyst.event-logger.data.event-log.table'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->timestamps();
        });

        Schema::create(Config::get('amethyst.event-logger.data.event-log-attribute.table'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->string('value')->index();
            $table->integer('event_log_id')->unsigned()->nullable();
            $table->foreign('event_log_id')->references('id')->on(Config::get('amethyst.event-logger.data.event-log.table'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists(Config::get('amethyst.event-logger.data.event-log.table'));
        Schema::dropIfExists(Config::get('amethyst.event-logger.data.event-log-attribute.table'));
    }
}
