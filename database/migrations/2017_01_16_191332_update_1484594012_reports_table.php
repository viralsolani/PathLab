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
            $table->integer('user_id')->unsigned()->nullable();
                $table->foreign('user_id', 'fk_8180_useruser_report')->references('id')->on('users');
                
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropForeign('fk_8180_user_user_id_report');
            $table->dropIndex('fk_8180_user_user_id_report');
            $table->dropColumn('user_id');
            
        });

    }
}
