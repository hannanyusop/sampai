<?php

namespace Tests\Feature;

use App\Domains\Auth\Models\Parcels;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\CreatesApplication;

class ParcelDataTest extends TestCase
{
    use CreatesApplication;

    public function test_dashboard_totals_do_not_hydrate_parcels()
    {
        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);
        DB::purge('sqlite');

        Schema::create('parcels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status');
        });
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->softDeletes();
        });
        Schema::create('offices', function (Blueprint $table) {
            $table->increments('id');
        });

        DB::table('parcels')->insert([
            ['status' => 1], ['status' => 2], ['status' => 3],
            ['status' => 4], ['status' => 4], ['status' => 5],
        ]);
        DB::table('users')->insert([
            ['type' => 'admin'], ['type' => 'user'], ['type' => 'user'],
        ]);
        DB::table('offices')->insert(['id' => 1]);

        $hydrated = 0;
        Parcels::retrieved(function () use (&$hydrated) {
            $hydrated++;
        });

        $this->assertSame([
            'all' => 6,
            'delivered' => 2,
            'return' => 1,
            'umel' => 1,
            'runner' => 1,
            'drop' => 1,
            'staff' => 1,
            'office' => 1,
            'user' => 2,
        ], parcelData());
        $this->assertSame(0, $hydrated, 'Dashboard counts must not load parcel models.');
    }
}
