<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccomodationConditionAndPricingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('accomodation_condition_and_pricings', function (Blueprint $table) {
            $table->id();
            $table->longText('description');
            $table->foreignId('included_in_accomodation_pricing_id')->constrained()->index('inclInAccPricing');
            $table->json('image');
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
        Schema::dropIfExists('accomodation_condition_and_pricings');
    }
}
