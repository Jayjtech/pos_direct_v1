<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        $users_list = User::paginate(10);
        $user = auth()->user();
        $ex = explode(" ", $user->name);
        $data = [
            'lastName' => end($ex),
            'users_list' => $users_list,
        ];

        return view('admin.users.user-list', $data);
    }

    public function userEditView(Request $request){
        $user = User::findOrFail($request->user_id);
        $roles = Role::all();
        $view = view('admin.users.partials.edit-user', compact('user','roles'))->render();
        return response()->json([
            'view' => $view,
        ]);
    }

    // Edit user
    public function saveUserChanges(Request $request){
        $user = User::findOrFail($request->user_id);
        $user->name = $request->name;
        $user->email = $request->email;
        if(!empty($request->password)){
            $user->password = Hash::make($request->password);
        }else{
            $user->password = $user->password;
        }
        
        // Remove previous roles
        $user_old_roles = $user->roles;
        foreach($user_old_roles as $old_role){
            $user->removeRole($old_role->name);
        }

        // Add the new roles
        foreach($request->roles as $role){
            $user->assignRole($role);
        } 

        $user->save();
        
        notify()->success('Changes successfully changed!');
        return back();
    }


    // Delete user
    public function deleteUser($id){
        try {
            $currentUser = auth()->user();
            $userToDelete = User::findOrFail($id);
            
            // Prevent self-deletion
            if($currentUser->id == $userToDelete->id) {
                notify()->error("You cannot delete your own account!");
                return back();
            }
            
            // Check if user has any active orders
            $orderCount = $userToDelete->order()->count();
            if($orderCount > 0) {
                notify()->error("Cannot delete '{$userToDelete->name}'. This user has {$orderCount} order(s) in the system. Consider deactivating the account instead.");
                return back();
            }
            
            // Check if user has any combined orders
            $combinedOrderCount = $userToDelete->combinedOrder()->count();
            if($combinedOrderCount > 0) {
                notify()->error("Cannot delete '{$userToDelete->name}'. This user has {$combinedOrderCount} transaction(s) in the system. Consider deactivating the account instead.");
                return back();
            }
            
            // Check if user has any active cart items
            $cartCount = \App\Models\Cart::where('user_id', $id)->count();
            if($cartCount > 0) {
                notify()->warning("Warning: User '{$userToDelete->name}' has {$cartCount} items in cart. These will be deleted.");
                // Clear user's cart before deletion
                \App\Models\Cart::where('user_id', $id)->delete();
                \App\Models\CartReport::where('user_id', $id)->delete();
            }
            
            // Check if user has any stock requests
            $stockCount = \App\Models\Stock::where('user_id', $id)->count();
            if($stockCount > 0) {
                notify()->error("Cannot delete '{$userToDelete->name}'. This user has {$stockCount} stock request(s). Please handle these requests first.");
                return back();
            }
            
            $userName = $userToDelete->name;
            
            // Remove roles and permissions
            foreach($userToDelete->roles as $role){
                $userToDelete->removeRole($role->name);
            }

            $permissionsViaRoles = $userToDelete->getPermissionsViaRoles();
            $directPermissions = $userToDelete->getDirectPermissions();
            $allPermissions = array_merge($permissionsViaRoles->toArray(), $directPermissions->toArray());
            $allPermissions = (object) array_unique($allPermissions);

            foreach($allPermissions as $permission){
                $userToDelete->revokePermissionTo($permission);
            }
            
            $userToDelete->delete();
            notify()->success("'{$userName}' account has been successfully deleted!");
            
            return back();
        } catch(Exception $e) {
            notify()->error('Error deleting user: ' . $e->getMessage());
            return back();
        }
    }
}