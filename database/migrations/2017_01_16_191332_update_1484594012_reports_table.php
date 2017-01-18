<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1484594012ReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->integer('user_id')->after('id')->unsigned();
                $table->foreign('user_id', 'fk_useruser_report')->references('id')->on('users');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reports', function (Blueprint $table)
        {
            $table->dropForeign('fk_useruser_report');
            $table->dropIndex('fk_useruser_report');
            $table->dropColumn('user_id');

        });

    }
}
