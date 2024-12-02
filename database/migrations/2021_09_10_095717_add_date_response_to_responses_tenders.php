<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDateResponseToResponsesTenders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('responses_tenders', function (Blueprint $table) {
            $table->date('dateResponse')->after('spreadDate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('responses_tenders', function (Blueprint $table) {
            $table->dropColumn('dateResponse');
        });
    }
}
