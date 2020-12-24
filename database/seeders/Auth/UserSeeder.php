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

        Office::create([
            'id' => 1,
            'code' => 'UMEL',
            'name' => 'PUSAT UTeM-MEL',
            'is_drop_point' => 0,
            'address' => 'Jalan TU 43 75450 Ayer Keroh, Malacca, Malaysia',
        ]);

        Office::create([
            'id' => 2,
            'code' => 'LEST',
            'name' => 'LESTARI',
            'is_drop_point' => 1,
            'address' => 'Kolej Kediaman Lestari, UTeM Kampus Induk',
        ]);

        // Add the master administrator, user id of 1
        User::create([
            'type' => User::TYPE_ADMIN,
            'name' => 'Super Admin',
            'email' => 'admin@mail.com',
            'password' => 'secret',
            'email_verified_at' => now(),
            'active' => true,
        ]);

        if (app()->environment(['local', 'testing'])) {
            User::create([
                'type' => User::TYPE_ADMIN,
                'office_id' => 1,
                'name' => 'UTeM-MEL STAFF',
                'email' => 'mel@mail.com',
                'password' => 'secret',
                'email_verified_at' => now(),
                'active' => true,
            ]);

            User::create([
                'type' => User::TYPE_ADMIN,
                'office_id' => 2,
                'name' => 'LESTARI',
                'email' => 'lestari@mail.com',
                'password' => 'secret',
                'email_verified_at' => now(),
                'active' => true,
            ]);

            User::create([
                'type' => User::TYPE_ADMIN,
                'office_id' => 0,
                'name' => 'RUNNER',
                'email' => 'runner@mail.com',
                'password' => 'secret',
                'email_verified_at' => now(),
                'active' => true,
            ]);

            User::create([
                'type' => User::TYPE_USER,
                'office_id' => 0,
                'name' => 'HANNAN YUSOP',
                'email' => 'student@mail.com',
                'password' => 'secret',
                'email_verified_at' => now(),
                'active' => true,
            ]);
        }

        $this->enableForeignKeys();
    }
}
