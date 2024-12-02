<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sportObject_id')->constrained('sport_objects');
            $table->boolean('payment_at_customer');
            $table->boolean('replay_estimate');
            $table->foreignId('rentSportObject_id')->constrained('rent_sport_objects');
            $table->foreignId('rentAccommodation_id')->constrained('rent_accommodations');
            $table->foreignId('rentAddition_id')->constrained('rent_additions');
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
        Schema::dropIfExists('estimates');
    }
}
