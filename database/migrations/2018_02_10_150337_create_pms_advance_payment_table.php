<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmsAdvancePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('pms_advance_payment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pms_contact_id')->unsigned()->nullable();
            $table->date('date')->nullable();
            $table->double('amount')->nullable();
            $table->double('remaining')->nullable();
            $table->integer('pay_through_id')->unsigned()->nullable();
            $table->integer('pms_account_id')->unsigned()->nullable();
            $table->string('notes')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::table('pms_advance_payment', function(Blueprint $table){
            $table->foreign('pms_contact_id')->references('id')->on('pms_contact')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('pay_through_id')->references('id')->on('pms_account')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('pms_account_id')->references('id')->on('pms_account')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pms_advance_payment');    }
}
