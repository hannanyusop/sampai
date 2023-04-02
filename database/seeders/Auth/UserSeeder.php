<?php

namespace Database\Seeders\Auth;

use App\Domains\Auth\Models\Office;
use App\Domains\Auth\Models\User;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

/**
 * Class UserTableSeeder.
 */
class UserSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();

        $limbang = Office::create([
            'id' => 1,
            'code' => 'LMN',
            'name' => 'PUSAT LIMBANG',
            'is_drop_point' => 0,
            'address' => 'Limbang, Sarawak',
        ]);

        $miri = Office::create([
            'id' => 2,
            'code' => 'MYY',
            'name' => 'PUSAT MIRI',
            'is_drop_point' => 0,
            'address' => 'Miri Sarawak',
        ]);

        $lambak = Office::create([
            'id' => 3,
            'code' => 'LBK',
            'name' => 'PUSAT PUNGUTAN LAMBAK',
            'is_drop_point' => 1,
            'address' => 'Lambak, Brunei',
        ]);

        $kilanas = Office::create([
            'id' => 4,
            'code' => 'KLN',
            'name' => 'PUSAT PUNGUTAN KILANAS',
            'is_drop_point' => 1,
            'address' => 'Kilanas, Brunei',
        ]);

        // Add the master administrator, user id of 1
        User::create([
            'type' => User::TYPE_ADMIN,
            'name' => 'Super Admin',
            'email' => 'admin@mail.com',
            'password' => 'secret',
            'email_verified_at' => now(),
            'default_drop_point' => Office::where('is_drop_point', 1)->first()->id,
            'phone_number' => '010'.rand(1000000,9999999),
            'active' => true,
        ]);

        if (app()->environment(['local', 'testing'])) {
            User::create([
                'type' => User::TYPE_ADMIN,
                'office_id' => $limbang->id,
                'name' => 'STAFF LIMBANG',
                'email' => 'limbang@mail.com',
                'password' => 'secret',
                'email_verified_at' => now(),
                'default_drop_point' => Office::where('is_drop_point', 1)->first()->id,
                'phone_number' => '010'.rand(1000000,9999999),
                'active' => true,
            ]);

            User::create([
                'type' => User::TYPE_ADMIN,
                'office_id' => $miri->id,
                'name' => 'STAFF MIRI',
                'email' => 'miri@mail.com',
                'password' => 'secret',
                'email_verified_at' => now(),
                'default_drop_point' => Office::where('is_drop_point', 1)->first()->id,
                'phone_number' => '010'.rand(1000000,9999999),
                'active' => true,
            ]);

            User::create([
                'type' => User::TYPE_ADMIN,
                'office_id' => $lambak->id,
                'name' => 'STAFF KINLANAS ',
                'email' => 'lamabak@mail.com',
                'password' => 'secret',
                'email_verified_at' => now(),
                'default_drop_point' => Office::where('is_drop_point', 1)->first()->id,
                'phone_number' => '010'.rand(1000000,9999999),
                'active' => true,
            ]);

            User::create([
                'type' => User::TYPE_ADMIN,
                'office_id' => $kilanas->id,
                'name' => 'STAFF KINLANAS ',
                'email' => 'kilanas@mail.com',
                'password' => 'secret',
                'email_verified_at' => now(),
                'default_drop_point' => Office::where('is_drop_point', 1)->first()->id,
                'phone_number' => '010'.rand(1000000,9999999),
                'active' => true,
            ]);

            User::create([
                'type' => User::TYPE_ADMIN,
                'office_id' => 0,
                'name' => 'RUNNER',
                'email' => 'runner@mail.com',
                'password' => 'secret',
                'email_verified_at' => now(),
                'default_drop_point' => Office::where('is_drop_point', 1)->first()->id,
                'phone_number' => '010'.rand(1000000,9999999),
                'active' => true,
            ]);

            User::create([
                'type' => User::TYPE_USER,
                'office_id' => 0,
                'name' => 'HANNAN YUSOP',
                'email' => 'student@mail.com',
                'password' => 'secret',
                'email_verified_at' => now(),
                'default_drop_point' => Office::where('is_drop_point', 1)->first()->id,
                'phone_number' => '010'.rand(1000000,9999999),
                'active' => true,
            ]);
        }

        $this->enableForeignKeys();
    }
}
