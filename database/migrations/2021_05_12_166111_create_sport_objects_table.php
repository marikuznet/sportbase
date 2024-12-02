<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSportObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('sport_objects', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->foreignId('objectType_id')->constrained('object_types');
            $table->json('image');
            $table->longText('description');
            $table->foreignId('sportType_id')->constrained('sport_types');
            $table->foreignId('accomodationConditionAndPricing_id')->constrained('accomodation_condition_and_pricings');
            $table->foreignId('city_id')->constrained();
            $table->string('address', 100);
            $table->integer('postIndex');
            $table->float('longtitude');
            $table->float('latitude');
            $table->float('rating')->default('0.0');
            $table->json('feedback_id')->nullable();
            $table->integer('user_id');
            $table->boolean('hasPromotion')->nullable();
            $table->boolean('hasHighlightion')->nullable();
            $table->boolean('hasVIP')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sport_objects');
    }
}
