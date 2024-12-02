<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDateCancelToDirectApplications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('direct_applications', function (Blueprint $table) {
            $table->timestamp('date_cancel')->default(null)->after('createDate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('direct_applications', function (Blueprint $table) {
            $table->dropColumn('date_cancel');
        });
    }
}
