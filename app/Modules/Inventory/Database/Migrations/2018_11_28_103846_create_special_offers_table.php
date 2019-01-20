<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_offers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('from_date');
            $table->string('to_date');
            $table->integer('company_id')->unsigned();
            $table->string('sku_id')->unsigned();
            $table->integer('sku_qty');
            $table->string('free_sku_id')->unsigned();
            $table->integer('free_sku_qty');
            $table->tinyInteger('status')->default(0);
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned();
            $table->timestamps();
        });

        Schema::table('special_offers', function(Blueprint $table){
            $table->foreign('company_id')->references('id')->on('contact')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('sku_id')->references('id')->on('item')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('free_sku_id')->references('id')->on('item')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('special_offers');
    }
}
