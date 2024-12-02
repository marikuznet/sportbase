<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsesTendersAndTypeSportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responses_tenders_and_type_sports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('responsesTender_id')->constrained('responses_tenders')->references('id');
            $table->foreignId('sportType_id')->constrained('sport_types');
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
        Schema::dropIfExists('responses_tenders_and_type_sports');
    }
}
