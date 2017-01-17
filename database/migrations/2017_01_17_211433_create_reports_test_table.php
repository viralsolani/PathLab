<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('report_test'))
        {
            Schema::create('report_test', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('report_id')->unsigned()->index();
                $table->integer('test_id')->unsigned()->index();
                $table->string('test_name');
                $table->text('result');

                $table->foreign('report_id')->references('id')->on('reports')->onDelete('cascade');
                $table->foreign('test_id')->references('id')->on('tests');
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
        Schema::dropIfExists('report_test');
    }
}
