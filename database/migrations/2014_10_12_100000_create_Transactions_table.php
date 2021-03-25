<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('transaction_id');
            $table->unsignedBigInteger('regkey');
            $table->integer('payed')->nullable();
            $table->boolean('visa')->nullable();
            $table->timestamp('transaction_date')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            
            $table->foreign('regkey')
            ->references('regkey')->on('patient_reg')
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
        Schema::dropIfExists('transactions');
    }
}
