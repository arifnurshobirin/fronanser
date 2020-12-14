<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashiers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idcard')->unique()->nullable();
            $table->integer('employee');
            $table->string('fullname');
            $table->date('dateofbirth');
            $table->string('address');
            $table->string('phonenumber')->unique();
            $table->string('position');
            $table->date('joindate');
            $table->string('avatar');
            $table->string('status');
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
        Schema::dropIfExists('cashiers');
    }
}
