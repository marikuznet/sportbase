<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccomodationTypeAndPricingAndObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accomodation_type_and_pricing_and_objects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sportObject_id')->constrained('sport_objects');
            $table->foreignId('accomodationType_id')->constrained('accomodation_type_and_pricings')->index('accTypeAndPricing');
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
        Schema::dropIfExists('accomodation_type_and_pricing_and_objects');
    }
}
