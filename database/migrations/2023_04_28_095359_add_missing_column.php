<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parcels', function (Blueprint $table){
            $table->integer('permit')->after('tax')->default(0);
            $table->boolean('checked')->after('permit')->default(0);
        });

        Schema::table('trip_batches', function (Blueprint $table){
            $table->integer('tax_rate')->after('date')->default(0);
            $table->integer('pos_rate')->after('tax_rate')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parcels', function (Blueprint $table){
            $table->dropColumn('permit');
            $table->dropColumn('checked');
        });

        Schema::table('trip_batches', function (Blueprint $table){
            $table->dropColumn('tax_rate');
            $table->dropColumn('pos_rate');
        });
    }
}
