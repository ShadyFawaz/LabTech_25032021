<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestEntryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_entry', function (Blueprint $table) {
            $table->id('result_id');
            $table->unsignedBigInteger('regkey');
            $table->unsignedBigInteger('test_id');
            $table->unsignedBigInteger('megatest_id');
            $table->string('result')->nullable();
            $table->string('unit')->nullable();
            $table->integer('low')->nullable();
            $table->integer('high')->nullable();
            $table->text('nn_normal')->nullable();
            $table->string('flag')->nullable();
            $table->text('result_comment')->nullable();
            $table->boolean('printed')->nullable();
            $table->boolean('report_printed')->default('1');
            $table->boolean('canceled')->nullable();
            $table->boolean('completed')->nullable()->default('0');
            $table->boolean('verified')->nullable()->default('0');
            // $table->integer('seperate_test')->default('0');
            // $table->integer('megatest_complete');
            $table->timestamps();

            $table->foreign('regkey')
           ->references('regkey')->on('patient_reg')
           ->onDelete('cascade')
           ->onUpate('cascade');
           $table->foreign('test_id')
           ->references('test_id')->on('test_data')
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
        Schema::dropIfExists('test_entry');
    }
}
