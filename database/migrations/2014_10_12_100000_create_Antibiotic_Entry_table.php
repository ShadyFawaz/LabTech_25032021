<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAntibioticEntryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antibiotic_entry', function (Blueprint $table) {
            $table->id('antibioticentry_id');
            $table->unsignedBigInteger('regkey');
            $table->unsignedBigInteger('culture_link');
            $table->unsignedBigInteger('organism_id')->nullable();
            $table->unsignedBigInteger('antibiotic_id')->nullable();
            $table->string('sensitivity')->nullable();


            
            $table->foreign('regkey')
           ->references('regkey')->on('Patient_Reg')
           ->onDelete('cascade')
           ->onUpate('cascade');
           $table->foreign('antibiotic_id')
           ->references('antibiotic_id')->on('Antibiotics')
           ->onDelete('cascade')
           ->onUpate('cascade');
           $table->foreign('organism_id')
           ->references('organism_id')->on('Organism')
           ->onDelete('cascade')
           ->onUpate('cascade');
           $table->foreign('culture_link')
           ->references('culturelink_id')->on('culture_link')
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
        Schema::dropIfExists('antibiotic_entry');
    }
}
