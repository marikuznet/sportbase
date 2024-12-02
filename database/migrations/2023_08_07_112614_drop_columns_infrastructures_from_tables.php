<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnsInfrastructuresFromTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('direct_applications', function (Blueprint $table) {
            $table->dropColumn('infrastructures');
        });
        Schema::table('tenders', function (Blueprint $table) {
            $table->dropColumn('infrastructures');
        });
        Schema::table('responses_tenders', function (Blueprint $table) {
            $table->dropColumn('infrastructures');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
