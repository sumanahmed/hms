<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountPglTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_pgl', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account_name');
            $table->integer('serial');
            $table->integer('account_gl_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('special_offers', function(Blueprint $table){
            $table->foreign('account_gl_id')->references('id')->on('account_gl')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_pgl');
    }
}
