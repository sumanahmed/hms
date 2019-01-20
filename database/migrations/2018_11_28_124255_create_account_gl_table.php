<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountGlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_gl', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account_name');
            $table->integer('serial');
            $table->integer('account_type_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('special_offers', function(Blueprint $table){
            $table->foreign('account_type_id')->references('id')->on('account_type')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_gl');
    }
}
