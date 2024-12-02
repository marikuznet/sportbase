<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->constrained();
            $table->string('legal_name')->nullable();;
            $table->string('title', 100)->nullable();
            $table->string('tin')->nullable();
            $table->string('numKpp')->nullable();
            $table->string('bic')->nullable();
            $table->string('requisites')->nullable();

            $table->string('kc')->nullable();
            $table->string('okpo')->nullable();
            $table->string('okato')->nullable();
            $table->string('orgn')->nullable();

            $table->integer('address_id')->constrained()->nullable();

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
        Schema::dropIfExists('payment_details');
    }
}
