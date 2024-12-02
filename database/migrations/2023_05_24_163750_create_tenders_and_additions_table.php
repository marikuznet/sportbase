<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTendersAndAdditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenders_and_additions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_id')->constrained('tenders')->references('id');
            $table->foreignId('additionTender_id')->constrained('addition_tenders', 'id')->references('id');
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
        Schema::dropIfExists('tenders_and_additions');
    }
}
