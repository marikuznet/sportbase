<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_companies', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->constrained();;
            $table->string('title', 100)->nullable();
            $table->json('image')->nullable();;
            $table->json('phoneCompany')->nullable();
            $table->string('quantityEmployees')->nullable();
            $table->string('emailCompany')->nullable();
            $table->string('site')->nullable();
            $table->string('description', 2000)->nullable();
            $table->integer('address_id')->constrained()->nullable();

            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedIn')->nullable();
            $table->string('telegram')->nullable();
            $table->string('slack')->nullable();
            $table->string('instagram')->nullable();

            $table->string('surname')->nullable();
            $table->string('name')->nullable();
            $table->string('patronymic')->nullable();
            $table->integer('position_id')->constrained()->nullable();
            $table->string('email')->nullable();
            $table->json('phone')->nullable();
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
        Schema::dropIfExists('info_companies');
    }
}
