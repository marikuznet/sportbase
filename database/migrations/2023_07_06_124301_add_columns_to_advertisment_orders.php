<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToAdvertismentOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advertisment_orders', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->date('date_end')->after('dateStart')->nullable();
            $table->boolean('paused')->after('description')->default(false);
            $table->dateTime('paused_at')->after('updated_at')->nullable();
            $table->unsignedBigInteger('payment_transaction_id')->after('id')->nullable();

            $table->foreign('payment_transaction_id')->references('id')->on('payment_transactions');
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
            $table->dropColumn('payment_transaction_id');
            $table->dropColumn('date_end');
            $table->dropColumn('paused');
            $table->dropColumn('paused_at');
           // $table->string('status')->after('description')->nullable();
        });
    }
}
