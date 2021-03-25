<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientRegTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_reg', function (Blueprint $table) {
            $table->id('regkey');
            $table->string('patient_id')->nullable();
            $table->integer('visit_no')->nullable();
            $table->unsignedBigInteger('title_id')->nullable();
            $table->string('patient_name');
            $table->string('gender');
            $table->date('dob')->nullable();
            $table->string('phone_number')->nullable();
            $table->integer('ag');
            $table->string('age');
            $table->timestamp('req_date')->useCurrent();
            $table->integer('disc')->default('0');
            $table->integer('discount')->default('0');
            $table->unsignedBigInteger('patient_condition')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('nationality')->nullable();
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->unsignedBigInteger('diagnosis_id')->nullable();
            $table->unsignedBigInteger('pricelist_id');
            $table->unsignedBigInteger('relative_pricelist_id');
            $table->unsignedBigInteger('user_id');
            $table->text('comment')->nullable();

            
            $table->foreign('title_id')
           ->references('title_id')->on('Titles')
           ->onDelete('cascade')
           ->onUpate('cascade');
           $table->foreign('country_id')
           ->references('country_id')->on('Country')
           ->onDelete('cascade')
           ->onUpate('cascade');
           $table->foreign('doctor_id')
           ->references('doctor_id')->on('Doctor')
           ->onDelete('cascade')
           ->onUpate('cascade');
           $table->foreign('diagnosis_id')
           ->references('diagnosis_id')->on('Diagnosis')
           ->onDelete('cascade')
           ->onUpate('cascade');
           $table->foreign('patient_condition')
           ->references('patientcondition_id')->on('Patient_condition')
           ->onDelete('cascade')
           ->onUpate('cascade');
           $table->foreign('pricelist_id')
           ->references('rank_pricelist_id')->on('rank_price_lists')
           ->onDelete('cascade')
           ->onUpate('cascade');
           $table->foreign('relative_pricelist_id')
           ->references('relative_pricelist_id')->on('relative_price_lists')
           ->onDelete('cascade')
           ->onUpate('cascade');
           $table->foreign('user_id')
           ->references('user_id')->on('users')
           ->onDelete('cascade')
           ->onUpate('cascade');


            $table->timestamp('registered_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_reg');
    }
}
