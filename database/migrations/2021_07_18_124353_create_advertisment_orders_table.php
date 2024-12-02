<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertismentOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisment_orders', function (Blueprint $table) {
            $table->id();
            $table->date('dateStart');
            $table->foreignId('sportObject_id')->constrained('sport_objects');
            $table->foreignId('rateAdvertisment_id')->constrained('rate_advertisments');
            $table->foreignId('statusAdvertisment_id')->constrained('status_advertisments');

            $table->decimal('amount', 10, 2)->default(0);
            $table->string('description', 255)->nullable();
            $table->string('status')->default('created');
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
        Schema::dropIfExists('advertisment_orders');
    }
}
