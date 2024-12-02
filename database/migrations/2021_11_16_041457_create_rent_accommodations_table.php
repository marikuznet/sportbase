<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentAccommodationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_accommodations', function (Blueprint $table) {
            $table->id();
            $table->boolean('checkAccm')->default(false);
            $table->json('accommodations')->nullable();
            $table->integer('daysAccm')->nullable();
            $table->float('priceFood')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->float('sumAccm')->nullable();
            $table->float('sumPriceFood')->nullable();
            $table->string('titlePriceFood')->nullable();
            $table->foreignId('typeFood_id')->nullable()->constrained('type_food');
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
        Schema::dropIfExists('rent_accommodations');
    }
}
