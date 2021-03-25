<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_parameters', function (Blueprint $table) {
            $table->id('parameter_id');
            $table->unsignedBigInteger('test_id');
            $table->string('test_parameter')->nullable();
            $table->timestamps();


           $table->foreign('test_id')
           ->references('test_id')->on('Test_Data')
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
        Schema::dropIfExists('test_parameters');
    }
}
