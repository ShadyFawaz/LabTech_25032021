<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNormalRangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('normal_ranges', function (Blueprint $table) {
            $table->id('normal_id');
            $table->unsignedBigInteger('test_id');
            $table->integer('low')->nullable();
            $table->integer('high')->nullable();
            $table->text('nn_normal');
            $table->string('gender');
            $table->integer('age_from');
            $table->integer('age_to');
            $table->string('age');
            $table->unsignedBigInteger('patient_condition')->nullable();
            $table->boolean('active');
            $table->timestamps();

            
            $table->foreign('test_id')
            ->references('test_id')->on('test_data')
            ->onDelete('cascade')
            ->onUpate('cascade');
            $table->foreign('patient_condition')
            ->references('patientcondition_id')->on('patient_condition')
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
        Schema::dropIfExists('normal_ranges');
    }
}
