<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_data', function (Blueprint $table) {
            $table->id('test_id');
            $table->string('abbrev')->unique();
            $table->string('report_name');
            $table->unsignedBigInteger('subgroup');
            $table->string('profile')->nullable();
            $table->string('test_header')->nullable();
            $table->unsignedBigInteger('unit')->nullable();
            $table->integer('test_order')->nullable();
            $table->integer('profile_order')->nullable();
            $table->unsignedBigInteger('culture_link')->nullable();
            $table->unsignedBigInteger('sample_type');
            $table->unsignedBigInteger('sample_condition');
            $table->unsignedBigInteger('lab_unit');
            $table->boolean('calculated');
            $table->text('test_equation')->nullable();
            $table->boolean('parent_test');
            $table->string('rpt');
            $table->string('default_value')->nullable();
            $table->integer('assay_time')->nullable();
            $table->timestamps();
            $table->foreign('subgroup')
           ->references('subgroup_id')->on('Subgroups')
           ->onDelete('cascade')
           ->onUpate('cascade');
           $table->foreign('lab_unit')
           ->references('labunit_id')->on('Lab_unit')
           ->onDelete('cascade')
           ->onUpate('cascade');
           $table->foreign('sample_type')
           ->references('sampletype_id')->on('Sample_Type')
           ->onDelete('cascade')
           ->onUpate('cascade');
           $table->foreign('sample_condition')
           ->references('samplecondition_id')->on('Sample_Condition')
           ->onDelete('cascade')
           ->onUpate('cascade');
           $table->foreign('unit')
           ->references('resultunit_id')->on('Results_Units')
           ->onDelete('cascade')
           ->onUpate('cascade');
           $table->foreign('culture_link')
           ->references('culturelink_id')->on('Culture_Link')
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
        Schema::dropIfExists('test_data');
    }
}
