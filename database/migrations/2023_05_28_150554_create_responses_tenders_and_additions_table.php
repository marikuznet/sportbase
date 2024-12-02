<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsesTendersAndAdditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responses_tenders_and_additions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('responsesTender_id')->constrained('responses_tenders')->references('id');
            $table->foreignId('additionTender_id')->constrained('addition_tenders')->references('id');
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
        Schema::dropIfExists('responses_tenders_and_additions');
    }
}
