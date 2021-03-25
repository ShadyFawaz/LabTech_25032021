<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reg_tracking', function (Blueprint $table) {
            $table->id('reg_track_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('regkey');
            $table->timestamp('mod_date')->useCurrent();

            $table->foreign('user_id')
           ->references('user_id')->on('Users')
           ->onDelete('cascade')
           ->onUpate('cascade');
            $table->foreign('regkey')
           ->references('regkey')->on('Patient_Reg')
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
        Schema::dropIfExists('reg_tracking');
    }
}
