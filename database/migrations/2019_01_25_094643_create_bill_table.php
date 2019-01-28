<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->unsigned();
            $table->integer('test_id')->unsigned();
            $table->integer('prescription_id')->unsigned();
            $table->string('bill_number');
            $table->double('amount');
            $table->double('due_amount');
            $table->string('bill_date')->nullable();
            $table->string('due_date')->nullable();
            $table->string('bill_from');
            $table->integer('summary')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::table('bill', function(Blueprint $table) {
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('test_id')->references('id')->on('tests')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('prescription_id')->references('id')->on('prescriptions')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bill');
    }
}
