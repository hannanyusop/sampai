<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePickupNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pickup_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pickup_id');
            $table->string('via'); // email, sms, whatsapp
            $table->string('address'); // email address or phone number
            $table->text('content');
            $table->string('status')->default('PENDING'); // PENDING, SENT, FAILED
            $table->text('provider_remark')->nullable(); // response from provider
            $table->timestamps();

            $table->foreign('pickup_id')->references('id')->on('pickups')->onDelete('cascade');
            $table->index(['pickup_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pickup_notifications');
    }
}
