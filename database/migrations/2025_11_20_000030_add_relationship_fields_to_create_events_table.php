<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCreateEventsTable extends Migration
{
    public function up()
    {
        Schema::table('create_events', function (Blueprint $table) {
            $table->unsignedBigInteger('venue_id')->nullable();
            $table->foreign('venue_id', 'venue_fk_10736011')->references('id')->on('venues');
            $table->unsignedBigInteger('seat_id')->nullable();
            $table->foreign('seat_id', 'seat_fk_10736012')->references('id')->on('seat_managements');
        });
    }
}
