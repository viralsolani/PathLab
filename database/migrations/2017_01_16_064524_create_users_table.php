<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->increments('id');
                 $table->integer('role_id')->unsigned()->nullable();
                $table->string('name');
                $table->string('email');
                $table->string('password');
                $table->string('remember_token')->nullable();

                $table->timestamps();
                $table->softDeletes();

                $table->foreign('role_id', 'fk_role_user')->references('id')->on('roles');
                $table->index(['deleted_at']);
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
        Schema::dropIfExists('users');
    }
}
