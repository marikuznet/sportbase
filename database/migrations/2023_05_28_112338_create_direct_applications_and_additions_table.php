<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectApplicationsAndAdditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direct_applications_and_additions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('directApplication_id')->constrained('direct_applications')->references('id');
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
        Schema::dropIfExists('direct_applications_and_additions');
    }
}
