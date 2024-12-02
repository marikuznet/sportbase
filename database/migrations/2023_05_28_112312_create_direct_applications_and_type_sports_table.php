<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectApplicationsAndTypeSportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direct_applications_and_type_sports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('directApplication_id')->constrained('direct_applications')->references('id');
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
        Schema::dropIfExists('direct_applications_and_type_sports');
    }
}
