<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
     // Role list
    public function index(){
        $user = auth()->user();
        $ex = explode(" ", $user->name);
        $roles = Role::paginate(10);
        $data = [
            'lastName' => end($ex),
            'roles' => $roles,
        ];
        
        return view('admin.roles.role-permission', $data);
    }

    public function roleEditView(Request $request){
       try{
            $role = Role::findOrFail($request->role_id);
            $permissions = Permission::all();
            $view = view('admin.roles.partials.edit-role', compact('role','permissions'))->render();
            return response()->json([
                'view' => $view,
            ]);
       }catch(Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ]);
       }
    }

    public function saveRoleChanges(Request $request){
        try{
            $role = Role::findOrFail($request->role_id);
            $role->name = $request->name;

            // Delete previous permissions that belongs to the role
            DB::table('role_has_permissions')->where('role_id', $request->role_id)->delete();

            // Add the new permissions
            foreach($request->permissions as $perm){
                $data = [
                    'permission_id' => $perm, 
                    'role_id' => $request->role_id, 
                ];

                DB::table('role_has_permissions')->insert($data);
            }

            $role->save();

            notify()->success('Changes successfully saved!');
            return back();

        }catch(Exception $e){
            notify()->error($e->getMessage());
            return back();
        }
    }


    // Delete role
    public function deleteRole($id){
        try {
            $role = Role::findOrFail($id);
            $roleName = $role->name;
            
            // Prevent deletion of critical system roles
            $protectedRoles = ['admin', 'super-admin', 'administrator'];
            if(in_array(strtolower($roleName), $protectedRoles)) {
                notify()->error("Cannot delete protected system role '{$roleName}'. This role is required for system operation.");
                return back();
            }
            
            // Check if role is assigned to users
            $userCount = DB::table('model_has_roles')
                          ->where('role_id', $id)
                          ->count();
                          
            if($userCount > 0) {
                notify()->error("Cannot delete role '{$roleName}'. This role is currently assigned to {$userCount} user(s). Please reassign these users to different roles first.");
                return back();
            }
            
            // Delete permissions that belong to the role
            DB::table('role_has_permissions')->where('role_id', $id)->delete();
            
            // Delete user role assignments (should be 0 at this point due to check above)
            DB::table('model_has_roles')->where('role_id', $id)->delete();
            
            $role->delete();
            notify()->success("Role '{$roleName}' has been successfully deleted!");
            
            return back();
        } catch(Exception $e) {
            notify()->error('Error deleting role: ' . $e->getMessage());
            return back();
        }
    }

    // Role add view
    public function roleAddView(){
        try{
            $permissions = Permission::all();
            $view = view('admin.roles.partials.add-role', compact('permissions'))->render();
            return response()->json([
                'view' => $view,
            ]);
        }catch(Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    // Add role
    public function addRole(Request $request){
        try{
            $role = Role::create(['name' => $request->name]);

            foreach($request->permissions as $perm){
                $data = [
                    'role_id' => $role->id,
                    'permission_id' => $perm
                ];

                DB::table('role_has_permissions')->insert($data);
            }

            notify()->success($request->name. ' successfully created!');
            return back();

        }catch(Exception $e){
            notify()->error($e->getMessage());
            return back();
        }
    }
}