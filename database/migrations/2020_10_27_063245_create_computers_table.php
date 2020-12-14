<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComputersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('computers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('counter_id');
            $table->integer('nocomputer')->unique();
            $table->string('type');
            $table->string('printer');
            $table->string('drawer');
            $table->string('scanner');
            $table->string('monitor');
            $table->string('status');
            $table->string('author')->nullable();
            $table->timestamps();
            $table->softDeletes();
            // $table->unique(['nocomputer']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('computers');
    }
}
