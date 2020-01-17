<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description');
            $table->unsignedBigInteger('line');
            $table->unsignedBigInteger('driver');
            $table->enum('schedule_type', ['daily', 'weekly', 'monthly', 'yearly', 'custom']);
            $table->dateTime('schedule_time')->nullable();
            $table->timestamps();

            $table->foreign('line')->references('id')->on('lines')->onDelete('cascade');
            $table->foreign('driver')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips');
    }
}
