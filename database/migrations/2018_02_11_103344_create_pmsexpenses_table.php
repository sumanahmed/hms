<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmsexpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pmsexpenses', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string("number");
            $table->date("date");
            $table->double("amount");            
            $table->double("due")->nullable();
            $table->string("note")->nullable();
            $table->integer("pms_contact_id")->unsigned()->nullable();
            $table->integer("pms_account_id")->unsigned()->nullable();
            $table->tinyInteger("admin_approval")->unsigned()->nullable()->comment = "0=not approved, 1=approved, null=still no decision";
            $table->double("approved_amount")->nullable();
            $table->string("file_url")->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();

        });

        //relation
        Schema::table('pmsexpenses', function(Blueprint $table){
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('pms_contact_id')->references('id')->on('pms_contact')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('pms_account_id')->references('id')->on('pms_account')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pmsexpenses');
    }
}
