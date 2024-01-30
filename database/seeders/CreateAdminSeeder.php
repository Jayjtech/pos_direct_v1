<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   $exists = User::where('email','admin@pos.com')->first();
        $permissions = Permission::pluck('id', 'id')->all();
        $role = Role::where('name', 'Admin')->first();
        if(!$exists){
            $user = User::create([
                'name' => 'Main Admin',
                'email' => 'admin@pos.com',
                'password' => Hash::make('12345'),
            ]);

            $user->assignRole($role);
            $role->syncPermissions($permissions);
        }else{
            $exists->assignRole($role);
            $role->syncPermissions($permissions);
        }  
    }
}