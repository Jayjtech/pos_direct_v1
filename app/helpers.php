<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Setting;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;


if (!function_exists('dateFormatter')) {
    function dateFormatter($date) {
        return $date ? Carbon::parse($date)->format('jS F Y h:ia') : '';
    }
}

if(!function_exists('orderStatus')){
    function orderStatus(int $value){
        switch($value){
            case 0:
                $status = "Pending";
                $color = "warning";
                break;
            case 1:
                $status = "Completed";
                $color = "success";
                break;
            case 2:
                $status = "Refunded";
                $color = "secondary";
                break;
        }
        $data = [
            'status' => $status,
            'color' => $color,
        ];

        return (object) $data;
    }
}

if(!function_exists('getStatus')){
    function getStatus(int $value){
        switch($value){
            case 0:
                $status = "Pending";
                $color = "warning";
                break;
            case 1:
                $status = "Successful";
                $color = "success";
                break;
        }
        $data = [
            'status' => $status,
            'color' => $color,
        ];

        return (object) $data;
    }
}
// Store permissions
if(!function_exists('storePermissions')){
    function storePermissions(){
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

            // Shop
            'shop',
        ];

        foreach ($permissions as $permission) {
            $exist = Permission::where('name', $permission)->first();
            if(!$exist){
                Permission::create(['name' => $permission]);
            }
        }
    }
    
}

if(!function_exists('storeRoles')){
    function storeRoles(){
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


if(!function_exists('createSuperAdmin')){
    function createSuperAdmin(){
        $exists = User::where('email','admin@pos.com')->first();
        $permissions = Permission::pluck('id', 'id')->all();
        $role = Role::where('name', 'Super Admin')->first();
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

if(!function_exists('createCompanyInfo')){
    function createCompanyInfo(){
        $company_info = Setting::all();
        if($company_info->count() == 0){
            Setting::create([
                'company_name' => 'POS Management System',
                'company_address' => 'Ota, Ogun State',
                'company_phones' => json_encode([
                    '07034876144',
                    '07069056472',
                ]),
                'company_email' => 'jayjtech5@gmail.com',
                'company_logo' => 'default_logo.jpg',
                'company_signature' => 'default_signature.png',
                'logo_status' => 1,
                'signature_status' => 1,
            ]);
        }
    }
}

if(!function_exists('getProductSales')){
    function getProductSales($startDate, $endDate, $product_id){
        if($startDate == $endDate){
            $sum = Order::where('product_id', $product_id)
                                    ->whereDate('created_at', $startDate)
                                    ->where('status', '!=', 2) //Refunded
                                    ->selectRaw('sum(qty) as qty_total, sum(sub_total) as grand_total, sum(discount) as disc_total')->first();
        }else{
            $sum = Order::where('product_id', $product_id)
                                ->whereBetween('created_at', [$startDate, $endDate])
                                ->where('status', '!=', 2) //Refunded
                                ->selectRaw('sum(qty) as qty_total, sum(sub_total) as grand_total, sum(discount) as disc_total')->first();
        }

        return (object) [
            'sum' => $sum,
        ];
    }
}

if(!function_exists('companyInfo')){
    function companyInfo(){
        $company_info = Setting::where('id', '!=', ' ')->first();
        return $company_info;
    }
}