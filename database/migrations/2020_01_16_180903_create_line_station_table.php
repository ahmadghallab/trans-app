<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLineStationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line_station', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('line');
            $table->unsignedBigInteger('station');
            $table->timestamps();

            $table->unique(['line', 'station']);

            $table->foreign('line')->references('id')->on('lines')->onDelete('cascade');
            $table->foreign('station')->references('id')->on('stations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('line_station');
    }
}
