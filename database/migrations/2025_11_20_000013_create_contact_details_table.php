<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('contact_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number')->nullable();
            $table->string('email')->nullable();
            $table->longText('address')->nullable();
            $table->longText('location_url')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
