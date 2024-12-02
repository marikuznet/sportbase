<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtherFieldsToTenders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenders', function (Blueprint $table) {
            $table->float('minPrice')->nullable()->after('priceForPerson');
            $table->float('rating')->nullable()->after('comment');
            $table->json('feedback')->nullable()->after('comment');
            $table->integer('archive')->default(0)->after('comment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tenders', function (Blueprint $table) {
            $table->dropColumn('minPrice');
            $table->dropColumn('rating');
            $table->dropColumn('feedback');
            $table->dropColumn('archive');
        });
    }
}
