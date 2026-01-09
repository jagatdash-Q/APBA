<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Role;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class RoleController extends Controller
{

    protected $rolesModel;
    protected $permissionModel;
    public function __construct()
    {
        $this->rolesModel = Config::get('laratrust.models.role');
        $this->permissionModel = Config::get('laratrust.models.permission');
    }
    public function manageRoles(Request $request)
    {
        if (!Auth::user()->hasPermission('role-read')) {
            abort(403);
        }
        $roles = Role::all();
        return view('dashboard.role-manager.index', ['roles' => $roles]);
    }

    public function editRole(Request $request, $id)
    {
        if (!Auth::user()->hasPermission('role-update')) {
            abort(403);
        }
        // get All permissions
        $permissions = Permission::all();
        $role_details = Role::with('getPermissions')->whereId($id)->first();
        if ($role_details != null) {
            if ($role_details->display_name == 'Superadmin') {
                return redirect()->back()->with('infoMessage', "System reserved role can't be editable");
            } else {
                return view('dashboard.role-manager.edit-role', ['permissions' => $permissions, 'role_details' => $role_details]);
            }
        } else {
            abort(404);
        }
    }

    public function updateRole(Request $request)
    {
        if (!Auth::user()->hasPermission('role-update')) {
            abort(403);
        }
        $role = Role::whereId($request->role_id)->first();
        if ($role != null) {
            if (count((array)$request->permissions)) {
                $role->permissions()->sync($request->permissions);
                return redirect()->route('admin.roles.manage')->with('doneMessage', "Permissions updated successfully");
            } else {
                return redirect()->route('admin.roles.manage')->with('infoMessage', "At least one permission is required for a role");
            }
        } else {
            abort(404);
        }
    }

    public function createRole(Request $request)
    {
        if (!Auth::user()->hasPermission('role-create')) {
            abort(403);
        }
        $permissions = Permission::all();
        return view('dashboard.role-manager.create-role', ['permissions' => $permissions]);
    }

    public function storeRole(Request $request)
    {
        if (!Auth::user()->hasPermission('role-create')) {
            abort(403);
        }
        $role = Role::where('name', strtolower($request->role_name))->first();
        if ($role == null) {
            if (count((array)$request->permissions)) {
                $role = Role::create([
                    'name' => strtolower($request->role_name),
                    'display_name' => $request->role_name, // optional
                    'description' => $request->role_name, // optional
                ]);
                $role->permissions()->sync($request->permissions);
                return redirect()->route('admin.roles.manage')->with('doneMessage', "Permissions updated successfully");
            } else {
                return redirect()->route('admin.roles.manage')->with('infoMessage', "At least one permission is required for a role");
            }
        } else {
            return redirect()->route('admin.roles.manage')->with('infoMessage', "Role name has been taken");
        }
    }


    public function deleteRole(Request $request)
    {
        if (!Auth::user()->hasPermission('role-delete')) {
            abort(403);
        }
        $role = Role::whereId($request->role_id)->first();
        if ($role == null) {
            return ['status' => 'error', 'message' => 'role not found'];
        } elseif ($role->display_name == 'Superadmin') {
            // Check if the role is superadmin
            return ['status' => 'error', 'message' => "System reserved role can't be deleted"];
        } else {
            // Check if user assigned to this role
            $is_users_assigned = RoleUser::where('role_id', $request->role_id)->count();
            if ($is_users_assigned) {
                return ['status' => 'error', 'message' => "Users were assigned in this role so it can't be deleted"];
            } else {
                Role::whereId($request->role_id)->delete();
                PermissionRole::where('role_id', $request->role_id)->delete();
                return ['status' => 'success', 'message' => "Role deleted successfully"];
            }
        }
    }
}
