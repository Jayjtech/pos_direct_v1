<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            // Order
            'generate-order',
            'generate-receipt',
            'view-receipt',
            
            // Company info
            'settings',

            // Category
            'create-product-category',
            'edit-product-category',
            'delete-product-category',

            // Product
            'create-product',
            'edit-product',
            'delete-product',

            // Stock
            'create-stock',
            'list-stock',
            'request-stock',
            'edit-stock',
            'delete-stock',
            'approve-stock',

            // Report
            'order-report', 
            'stock-report', 
            'general-report', 

            // Users
            'edit-user',
            'edit-user',
            'delete-user',
            
            // Role
            'create-role',
            'edit-role',
            'delete-role',
        ];

        foreach ($permissions as $permission) {
            $exist = Permission::where('name', $permission)->first();
            if(!$exist){
                Permission::create(['name' => $permission]);
            }
        }
    }
}