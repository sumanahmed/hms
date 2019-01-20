<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmsAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pms_account', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pms_account_sub_type_id')->unsigned()->nullable();
            $table->tinyInteger('required')->unsigned()->nullable()->comment ="null=can delete, 1=can not delete";
            $table->string('title')->nullable();
            $table->string('summary')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::table('pms_account', function(Blueprint $table){
            $table->foreign('pms_account_sub_type_id')->references('id')->on('pms_account_sub_type')->onDelete('set null')->onUpdate('set null');
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
        Schema::dropIfExists('pms_account');
    }
}
