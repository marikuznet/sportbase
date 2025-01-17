<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatsToAdvertismentOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advertisment_orders', function (Blueprint $table) {
            $table->integer('views')->default(0);
            $table->integer('clicks')->default(0);
            $table->integer('conversions')->default(0);
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
            $table->dropColumn('views');
            $table->dropColumn('clicks');
            $table->dropColumn('conversions');
        });
    }
}
