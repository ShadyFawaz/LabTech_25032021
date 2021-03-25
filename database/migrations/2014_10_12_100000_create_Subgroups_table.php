<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubgroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Subgroups', function (Blueprint $table) {
            $table->id('subgroup_id');
            $table->unsignedBigInteger('group_id');
            $table->string('subgroup_name')->nullable();
            $table->string('report_name')->nullable();
            $table->foreign('group_id')
           ->references('group_id')->on('Groups')
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
        Schema::dropIfExists('Subgroups');
    }
}
