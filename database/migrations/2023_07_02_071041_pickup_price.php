<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PickupPrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pickups', function (Blueprint $table){
            $table->integer('total_price')->after('pickup_name');
        });

        Schema::table('parcels', function (Blueprint $table){
            $table->integer('code')->after('tracking_no');
            $table->decimal('cod_fee')->after('price')->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pickups', function (Blueprint $table){
            $table->dropColumn('total_price');
        });

        Schema::table('parcels', function (Blueprint $table){
            $table->dropColumn('code');
            $table->dropColumn('cod_fee');
        });
    }
}
