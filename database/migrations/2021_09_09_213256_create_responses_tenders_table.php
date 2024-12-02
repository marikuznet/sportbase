<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsesTendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responses_tenders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('infoCompany_id');
            $table->json('infrastructures');
            $table->foreignId('city_id')->constrained();
            $table->date('createDate');
            $table->date('startDate');
            $table->date('endDate');
            $table->string('spreadDate');
            $table->integer('colPeople');
            $table->float('minPrice');
            $table->float('priceForPerson');
            $table->string('comment');
            $table->integer('archive')->default(0);
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
        Schema::dropIfExists('responses_tenders');
    }
}
