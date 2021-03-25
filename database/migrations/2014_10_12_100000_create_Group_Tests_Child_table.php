<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupTestsChildTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_tests_child', function (Blueprint $table) {
            $table->id('grouptest_code');
            $table->unsignedBigInteger('grouptest_id');
            $table->unsignedBigInteger('test_id');
            $table->boolean('active');

            $table->foreign('grouptest_id')
           ->references('grouptest_id')->on('Group_Tests')
           ->onDelete('cascade')
           ->onUpdate('cascade');
           $table->foreign('test_id')
           ->references('test_id')->on('test_data')
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
        Schema::dropIfExists('group_tests_child');
    }
}
