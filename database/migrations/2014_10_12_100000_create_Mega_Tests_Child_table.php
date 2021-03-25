<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMegaTestsChildTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mega_tests_child', function (Blueprint $table) {
            $table->id('test_code');
            $table->unsignedBigInteger('megatest_id');
            $table->unsignedBigInteger('test_id');
            $table->boolean('active');

            $table->foreign('megatest_id')
           ->references('megatest_id')->on('Mega_Tests')
           ->onDelete('cascade')
           ->onUpate('cascade');
           $table->foreign('test_id')
           ->references('test_id')->on('test_data')
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
        Schema::dropIfExists('mega_tests_child');
    }
}
