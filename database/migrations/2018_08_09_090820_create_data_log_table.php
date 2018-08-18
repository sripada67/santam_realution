<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dataLog', function (Blueprint $table) {
            $table->increments('id');
            $table->string('profile_type'); 
            $table->string('transaction_id');
            $table->string('method');
            $table->longText('request');
            $table->longText('response');
            $table->integer('result_code');            
            $table->string('reason');
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dataLog');
    }
}
