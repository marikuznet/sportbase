<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccomodationTypeAndPricingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('accomodation_type_and_pricings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accomodationType_id')->constrained('accomodation_types');
            $table->longText('description');
            $table->json('price');
            $table->foreignId('accCondAndPricing_id')->constrained('accomodation_condition_and_pricings');

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
        Schema::dropIfExists('accomodation_type_and_pricings');
    }
}
