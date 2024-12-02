<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentAdditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_additions', function (Blueprint $table) {
            $table->id();
            $table->boolean('checkLaundry')->default(false);
            $table->integer('washingVolume')->nullable();
            $table->float('priceWashing')->nullable();
            $table->float('sumLaundry')->nullable();
            $table->boolean('checkTransfer')->nullable();
            $table->integer('durationTransfer')->nullable();
            $table->float('priceTransfer')->nullable();
            $table->float('sumTransfer')->nullable();
            $table->json('infrastructures')->nullable();
            $table->float('totalPrice')->nullable();
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
        Schema::dropIfExists('rent_additions');
    }
}
