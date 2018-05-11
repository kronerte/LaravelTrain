<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::create('users', function(Blueprint $table) {
           $table->increments('id');
           $table->string('pseudo',100)->unique();
           $table->string('password',100);
           $table->string('mail',100)->unique()->nullable();
           $table->string('FacebookProvider',100)->unique()->nullable();
           $table->string('confirmationCode',100)->nullable();
           $table->boolean('confirmation')->default(0);
       });
     }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
