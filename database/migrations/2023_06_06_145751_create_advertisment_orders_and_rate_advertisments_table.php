<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertismentOrdersAndRateAdvertismentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisment_orders_and_rate_advertisments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rate_advertisment_id');
            $table->unsignedBigInteger('advertisment_order_id');
            $table->timestamps();

            $table->foreign('rate_advertisment_id', 'fk_aora_rate_advertisment_id')
                ->references('id')
                ->on('rate_advertisments');

            $table->foreign('advertisment_order_id', 'fk_aora_advertisment_order_id')
                ->references('id')
                ->on('advertisment_orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertisment_orders_and_rate_advertisments');
    }
}
