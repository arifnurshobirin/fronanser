<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counters', function (Blueprint $table) {
            $table->id();
            $table->integer('nocounter')->unique();
            $table->ipAddress('ipaddress')->unique();
            $table->macAddress('macaddress')->unique();
            $table->string('type');
            $table->string('status');
            $table->string('author')->nullable();
            $table->timestamps();
            $table->softDeletes();
            // $table->unique(['nocounter', 'ipaddress','macaddress']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('counters');
    }
}
