<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutlabTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outlab_tests', function (Blueprint $table) {
            $table->id('testprice_id');
            $table->unsignedBigInteger('outlab_id');
            $table->unsignedBigInteger('megatest_id');
            $table->integer('duration');
            $table->integer('price');

            $table->foreign('outlab_id')
           ->references('outlab_id')->on('out_labs')
           ->onDelete('cascade')
           ->onUpate('cascade');
           $table->foreign('megatest_id')
           ->references('megatest_id')->on('mega_tests')
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
        Schema::dropIfExists('outlab_tests');
    }
}
