<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSeatManagementsTable extends Migration
{
    public function up()
    {
        Schema::table('seat_managements', function (Blueprint $table) {
            $table->unsignedBigInteger('venue_id')->nullable();
            $table->foreign('venue_id', 'venue_fk_10735993')->references('id')->on('venues');
        });
    }
}
