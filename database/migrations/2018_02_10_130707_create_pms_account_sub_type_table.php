<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmsAccountSubTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('pms_account_sub_type', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pms_account_type_id')->unsigned()->nullable();
            $table->string('title')->nullable();
            $table->timestamps();
        });

       Schema::table('pms_account_sub_type', function(Blueprint $table){
            $table->foreign('pms_account_type_id')->references('id')->on('pms_account_type')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pms_account_sub_type');
    }
}
