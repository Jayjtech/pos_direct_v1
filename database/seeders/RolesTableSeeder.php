<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'Super Admin',
            'Cashier',
            'Stock keeper',
            'Sales person',
        ];

        foreach ($roles as $role) {
            $exist = Role::where('name', $role)->first();
            if(!$exist){
                Role::create(['name' => $role]);
            }
        }
    }
}