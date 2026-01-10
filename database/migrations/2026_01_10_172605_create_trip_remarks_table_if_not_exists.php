<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripRemarksTableIfNotExists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('trip_remarks')) {
            Schema::create('trip_remarks', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('trip_id');
                $table->unsignedBigInteger('user_id');
                $table->string('text', 200);
                $table->timestamps();

                $table->foreign('trip_id')->references('id')->on('trips')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trip_remarks');
    }
}
