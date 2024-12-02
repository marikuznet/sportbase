<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_details', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            $table->json('phones')->nullable();
            $table->string('email')->nullable();
            $table->string('site')->nullable();
            $table->text('description')->nullable();

            $table->text('ur_name')->nullable();
            $table->string('ur_pre')->nullable();
            $table->string('ur_title')->nullable();
            $table->string('tin')->nullable();
            $table->string('numKpp')->nullable();
            $table->string('bic')->nullable();
            $table->string('requisites')->nullable();

            $table->string('kc')->nullable();
            $table->string('okpo')->nullable();
            $table->string('okato')->nullable();
            $table->string('orgn')->nullable();

            $table->string('logo')->nullable();
            $table->string('print')->nullable();
            $table->string('signature')->nullable();

            $table->unsignedBigInteger('fact_address_id')->nullable();
            $table->unsignedBigInteger('ur_address_id')->nullable();

            $table->foreign('fact_address_id')->references('id')->on('addresses');
            $table->foreign('ur_address_id')->references('id')->on('addresses');

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
        Schema::dropIfExists('settings_details');
    }
}
