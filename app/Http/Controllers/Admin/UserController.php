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
        $user = User::findOrFail($id);
        foreach($user->roles as $role){
            $user->removeRole($role->name);
        }

        $permissionsViaRoles = $user->getPermissionsViaRoles();

        $directPermissions = $user->getDirectPermissions();

        $allPermissions = array_merge($permissionsViaRoles->toArray(), $directPermissions->toArray());

        $allPermissions = (object) array_unique($allPermissions);

        foreach($allPermissions as $permission){
            $user->revokePermissionTo($permission);
        }
        notify()->info($user->name."'s account has been deleted!");
        $user->delete();
        return back();
    }
}