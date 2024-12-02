<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDaysAdvertisementToAdvertismentOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advertisment_orders', function (Blueprint $table) {
            $table->integer('days')->after('rateAdvertisment_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('advertisment_orders', function (Blueprint $table) {
            $table->dropColumn('days');
        });
    }
}
