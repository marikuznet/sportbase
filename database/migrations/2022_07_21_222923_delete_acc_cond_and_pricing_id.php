<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteAccCondAndPricingId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasColumn('accomodation_type_and_pricings','accCondAndPricing_id')) {

            Schema::table('accomodation_type_and_pricings',function (Blueprint $table) {
                $table->dropForeign(['accCondAndPricing_id']);
                $table->dropColumn('accCondAndPricing_id');

            });

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
