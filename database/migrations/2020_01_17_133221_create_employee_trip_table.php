<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTripTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_trip', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('trip');
            $table->unsignedBigInteger('employee');
            $table->timestamp('subscribed_at')->nullable();
            $table->timestamp('confirmation_sent_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();

            $table->unique(['trip', 'employee']);

            $table->foreign('trip')->references('id')->on('trips')->onDelete('cascade');
            $table->foreign('employee')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_trip');
    }
}
