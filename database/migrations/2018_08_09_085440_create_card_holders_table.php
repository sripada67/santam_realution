<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardHoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cardholders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('customer_no');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('id_no');
            $table->string('passport_id');
            $table->string('address1');
            $table->string('address2');
            $table->string('suburb');
            $table->string('city');
            $table->string('postal_code');
            $table->string('province');
            $table->string('work_contact');
            $table->string('cell_contact');
            $table->string('home_contact');
            $table->string('extra');
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
        Schema::drop('cardholders');
    }
}