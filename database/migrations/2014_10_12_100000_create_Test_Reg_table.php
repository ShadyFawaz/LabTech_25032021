<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestRegTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_reg', function (Blueprint $table) {
            $table->id('testreg_id');
            $table->unsignedBigInteger('regkey');
            $table->unsignedBigInteger('megatest_id');
            $table->integer('patient_fees')->nullable();
            $table->integer('insurance_fees')->nullable();
            $table->boolean('inlab')->nullable();
            $table->boolean('outlab')->nullable();
            $table->unsignedBigInteger('lab_name')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->boolean('canceled')->nullable();
            $table->boolean('registered')->nullable();

            
            $table->foreign('regkey')
           ->references('regkey')->on('patient_reg')
           ->onDelete('cascade')
           ->onUpate('cascade');
           $table->foreign('megatest_id')
           ->references('megatest_id')->on('mega_tests')
           ->onDelete('cascade')
           ->onUpate('cascade');
           $table->foreign('user_id')
           ->references('user_id')->on('Users')
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
        Schema::dropIfExists('test_reg');
    }
}
