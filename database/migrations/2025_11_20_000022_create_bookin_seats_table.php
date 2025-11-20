<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookinSeatsTable extends Migration
{
    public function up()
    {
        Schema::create('bookin_seats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('seat_code')->nullable();
            $table->string('row')->nullable();
            $table->string('column')->nullable();
            $table->string('price')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
