<?php

namespace Database\Seeders\Auth;

use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Models\User;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

/**
 * Class UserRoleTableSeeder.
 */
class UserRoleSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();

        User::find(1)->assignRole(config('boilerplate.access.role.admin'));

        $runner = Permission::where('name', 'staff.runner')->first()->id;
        $manager = Permission::where('name', 'staff.manager')->first()->id;
        $officer = Permission::where('name', 'staff.inhouse')->first()->id;
        $distributor = Permission::where('name', 'staff.distributor')->first()->id;

        $mel = User::find(2);
        $mel->assignRole(2);
        $mel->syncPermissions([$distributor]);

        $les = User::find(3);
        $les->assignRole(2);
        $les->syncPermissions([$manager, $officer]);

        $run = User::find(4);
        $run->assignRole(2);
        $run->syncPermissions([$runner]);

        $this->enableForeignKeys();
    }
}
