<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToBookinSeatsTable extends Migration
{
    public function up()
    {
        Schema::table('bookin_seats', function (Blueprint $table) {
            $table->unsignedBigInteger('hall_id')->nullable();
            $table->foreign('hall_id', 'hall_fk_10736001')->references('id')->on('venues');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_10736002')->references('id')->on('users');
        });
    }
}
