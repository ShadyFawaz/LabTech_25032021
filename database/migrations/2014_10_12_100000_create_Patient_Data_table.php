<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_data', function (Blueprint $table) {
            $table->id('patient_code');
            $table->string('Patient_ID');
            $table->unsignedBigInteger('Title_id')->nullable();
            $table->string('patient_name');
            $table->date('DOB')->nullable();
            $table->string('phone_number')->nullable();
            $table->integer('Ag');
            $table->string('Age');
            $table->string('Gender');
            $table->string('Address')->nullable();
            $table->string('Email')->nullable();
            $table->string('Website')->nullable();
            $table->string('Country')->nullable();
            $table->string('Nationality')->nullable();
            $table->timestamps();
            $table->foreign('Title_id')
           ->references('title_id')->on('Titles')
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
        Schema::dropIfExists('patient_data');
    }
}
