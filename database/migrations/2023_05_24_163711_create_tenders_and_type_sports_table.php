<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTendersAndTypeSportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenders_and_type_sports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_id')->constrained('tenders')->references('id');
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
        Schema::dropIfExists('tenders_and_type_sports');
    }
}
