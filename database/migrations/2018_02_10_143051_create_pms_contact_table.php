<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmsContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('pms_contact', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pms_contact_category_id')->unsigned()->nullable();
            $table->integer('pms_account_id')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->string('contactNumber')->nullable();
            $table->string('address')->nullable();
            $table->text('remarks')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();
        });

       Schema::table('pms_contact', function(Blueprint $table){
            $table->foreign('pms_contact_category_id')->references('id')->on('pms_contact_category')->onDelete('set null')->onUpdate('set null');
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
        //
    }
}
