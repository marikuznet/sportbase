<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsesTenderAndTendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responses_tender_and_tenders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('responsesTender_id')->constrained('responses_tenders')->references('id');
            $table->foreignId('tender_id')->constrained('tenders');
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
        Schema::dropIfExists('responses_tender_and_tenders');
    }
}
