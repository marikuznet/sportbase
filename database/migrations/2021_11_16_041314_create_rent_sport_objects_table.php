<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentSportObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_sport_objects', function (Blueprint $table) {
            $table->id();
            $table->boolean('checkSport')->default(false);
            $table->float('price')->nullable();
            $table->float('sum')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->boolean('time')->nullable();
            $table->integer('training')->nullable();
            $table->json('trainingTime')->nullable();
            $table->json('trainingTime_diff')->nullable();
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
        Schema::dropIfExists('rent_sport_objects');
    }
}
