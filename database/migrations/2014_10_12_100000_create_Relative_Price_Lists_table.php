<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelativePriceListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relative_price_lists', function (Blueprint $table) {
            $table->id('relative_pricelist_id');
            $table->unsignedBigInteger('pricelist_id');
            $table->unsignedBigInteger('rank_pricelist_id');
            $table->string('relative_pricelist_name')->nullable();
            $table->integer('patient_load')->nullable();
            $table->integer('insurance_load')->nullable();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('pricelist_id')
           ->references('pricelist_id')->on('price_lists')
           ->onDelete('cascade')
           ->onUpdate('cascade');

           $table->foreign('rank_pricelist_id')
           ->references('rank_pricelist_id')->on('rank_price_lists')
           ->onDelete('cascade')
           ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relative_price_lists');
    }
}
