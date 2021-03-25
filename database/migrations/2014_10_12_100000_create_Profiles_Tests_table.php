<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles_tests', function (Blueprint $table) {
            $table->id('profiletest_id');
            $table->unsignedBigInteger('profile_id');
            $table->unsignedBigInteger('megatest_id');

            $table->foreign('profile_id')
           ->references('profile_id')->on('Profiles')
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
        Schema::dropIfExists('profiles_tests');
    }
}
