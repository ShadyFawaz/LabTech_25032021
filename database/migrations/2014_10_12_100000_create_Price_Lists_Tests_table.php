<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceListsTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_lists_tests', function (Blueprint $table) {
            $table->id('testprice_id');
            $table->unsignedBigInteger('pricelist_id');
            $table->unsignedBigInteger('megatest_id');
            $table->integer('price')->nullable();
            $table->foreign('pricelist_id')
           ->references('pricelist_id')->on('Price_Lists')
           ->onDelete('cascade')
           ->onUpate('cascade');
           $table->foreign('megatest_id')
           ->references('megatest_id')->on('Mega_Tests')
           ->onDelete('cascade')
           ->onUpate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('price_lists_tests');
    }
}
