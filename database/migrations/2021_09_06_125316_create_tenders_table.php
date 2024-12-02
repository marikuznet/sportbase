<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenders', function (Blueprint $table) {
            $table->id();
            $table->json('infrastructures');
            $table->foreignId('city_id')->constrained();
            $table->date('createDate');
            $table->foreignId('user_id')->constrained('users');
            $table->date('startDate');
            $table->date('endDate');
            $table->string('spreadDate');
            $table->integer('colPeople');
            $table->float('priceForPerson');
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
        Schema::dropIfExists('tenders');
    }
}
