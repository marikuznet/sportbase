<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAcceptToDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deals', function (Blueprint $table) {
            $table->boolean('accept_by_customer')->default(false)->after('status');
            $table->boolean('accept_by_executor')->default(false)->after('accept_by_customer');
            $table->dateTime('accept_customer_date')->nullable()->after('accept_by_executor');
            $table->dateTime('accept_executor_date')->nullable()->after('accept_customer_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deals', function (Blueprint $table) {
            //
        });
    }
}
