<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsolidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consolidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cashier_id');
            $table->foreignId('counter_id');
            $table->foreignId('banknote_id');
            $table->foreignId('coin_id');
            $table->string('nodeposit')->unique();
            $table->date('date');
            $table->time('time');
            $table->string('type');
            $table->integer('amount');
            $table->string('author')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consolidates');
    }
}
