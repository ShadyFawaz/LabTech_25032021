<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('result_tracking', function (Blueprint $table) {
            $table->id('track_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('result_id');
            $table->unsignedBigInteger('regkey');
            $table->unsignedBigInteger('test_id');
            $table->string('result')->nullable();
            $table->timestamp('modify_time')->useCurrent();
            $table->timestamps();


            $table->foreign('user_id')
           ->references('user_id')->on('Users')
           ->onDelete('cascade')
           ->onUpdate('cascade');
            $table->foreign('regkey')
           ->references('regkey')->on('Patient_Reg')
           ->onDelete('cascade')
           ->onUpdate('cascade');
           $table->foreign('test_id')
           ->references('test_id')->on('Test_Data')
           ->onDelete('cascade')
           ->onUpdate('cascade');
           $table->foreign('result_id')
           ->references('result_id')->on('test_entry')
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
        Schema::dropIfExists('result_tracking');
    }
}
