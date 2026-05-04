<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles=['admin','user','vendor','affiliate'];

        foreach($roles as $role){
            Role::firstOrCreate([
                'name'=>$role,
                'guard_name'=>'web'
            ]);
        }

        $admin= User::find(1);
        $admin->assignRole('admin');

        $adminRole = Role::find(1);

        $adminRole->syncPermissions(Permission::all());

        $user= User::find(2);
        $user->assignRole('user');

        $vendor= User::find(3);
        $vendor->assignRole('vendor');

        $affiliate = User::find(4);
        $affiliate->assignRole('affiliate');


    }
}
