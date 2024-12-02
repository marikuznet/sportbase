<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direct_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('infoCompany_id');
            $table->foreignId('sportObject_id')->constrained('sport_objects');
            $table->json('infrastructures');
            $table->foreignId('city_id')->constrained();
            $table->date('createDate');
            $table->foreignId('user_id')->constrained('users');
            $table->date('startDate');
            $table->date('endDate');
            $table->string('spreadDate');
            $table->integer('colPeople');
            $table->float('priceForPerson');
            $table->float('minPrice')->nullable();
            $table->float('rating')->nullable();
            $table->json('feedback')->nullable();
            $table->integer('archive')->default(0);
            $table->string('comment');
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
        Schema::dropIfExists('direct_applications');
    }
}
