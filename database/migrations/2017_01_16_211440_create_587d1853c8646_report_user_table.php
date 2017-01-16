<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create587d1853c8646ReportUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('report_user')) {
            Schema::create('report_user', function (Blueprint $table) {
                $table->integer('report_id')->unsigned()->nullable();
                $table->foreign('report_id', 'fk_p_8288_8180_user_report')->references('id')->on('reports');
                $table->integer('user_id')->unsigned()->nullable();
                $table->foreign('user_id', 'fk_p_8180_8288_report_user')->references('id')->on('users');
                
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
        Schema::dropIfExists('report_user');
    }
}
