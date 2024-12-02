<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectApplicationsAndInfrastructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direct_applications_and_infrastructures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('directApplication_id')
                ->constrained('direct_applications')
                ->references('id')
                ->name('fk_direct_applications_and_infrastructures_directApplication_id');

            $table->foreignId('infrastructure_id')
                ->constrained('requirement_infrastructures')
                ->references('id')
                ->name('fk_direct_applications_and_infrastructures_infrastructure_id');

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
        Schema::dropIfExists('direct_applications_and_infrastructures');
    }
}
