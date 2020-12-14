<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEdcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edcs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('counter_id');
            $table->string('tidedc');
            $table->string('midedc');
            $table->string('ipaddress')->unique();
            $table->string('connection');
            $table->string('simcard');
            $table->string('type');
            $table->string('status');
            $table->string('author')->nullable();
            $table->timestamps();
            $table->softDeletes();
            //$table->unique(['tidedc', 'ipaddress']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('edcs');
    }
}
