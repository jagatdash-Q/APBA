<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    protected $rolesModel;
    protected $permissionModel;
    public function __construct()
    {
        $this->rolesModel = Config::get('laratrust.models.role');
        $this->permissionModel = Config::get('laratrust.models.permission');
    }
    public function manageUsers(Request $request)
    {
        if (!Auth::user()->hasPermission('users-read'))
            abort(403);
        $user = User::with('getRole')->get();
        return view('dashboard.user-manager.index', compact('user'));
    }

    public function edituser(Request $request, $id)
    {
        if (!Auth::user()->hasPermission('users-update'))
            abort(403);
        // get All permissions
        $roles = Role::where('name', '!=', 'superadmin')->get();
        $user_details = User::whereId($id)->with('getRole')->first();
        if ($user_details != null) {
            if ($user_details->getRole != null) {
                if ($user_details->getRole->getRoleDetails != null) {
                    if ($user_details->getRole->getRoleDetails->display_name == 'Superadmin') {
                        return redirect()->route('admin.users.manage')->with('infoMessage', "System reserved role can't be editable");
                    } else {
                        return view('dashboard.user-manager.edit-user', compact('roles', 'user_details'));
                    }
                } else {
                    abort(404);
                }
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    public function updateUser(Request $request)
    {
        if (!Auth::user()->hasPermission('users-update'))
            abort(403);
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'role' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $is_user_exist = user::whereId($request->id)->first();
        $form_data = array(
            'name' => $request->name,
            'password' => Hash::make($request->new_password),
        );
        $is_user_exist->whereId($request->id)->update($form_data);
        $is_user_exist->roles()->sync($request->role);
        return redirect()->route('admin.users.manage')->with('doneMessage', "User details updated successfully");
    }

    public function createUser(Request $request)
    {
        if (!Auth::user()->hasPermission('users-create'))
            abort(403);
        $roles = Role::where('name', '!=', 'superadmin')->get();
        return view('dashboard.user-manager.create-user', compact('roles'));
    }

    public function storeUser(Request $request)
    {
        if (!Auth::user()->hasPermission('users-create'))
            abort(403);
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|unique:users,email',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6',
            'role' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user_details = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ];
        $user = User::create($user_details);
        $user->addRole($request->role);
        return redirect()->route('admin.users.manage')->with('doneMessage', "User created successfully");
    }


    public function deleteUser(Request $request)
    {
        if (!Auth::user()->hasPermission('users-delete'))
            abort(403);
        $user_details = User::whereId($request->id)->with('getRole')->first();
        if ($user_details == null) {
            return ['status' => 'error', 'message' => 'role not found'];
        } else {
            if ($user_details->getRole != null) {
                if ($user_details->getRole->getRoleDetails != null) {
                    if ($user_details->getRole->getRoleDetails->display_name == 'Superadmin') {
                        return redirect()->route('admin.users.manage')->with('infoMessage', "System reserved role can't be deletable");
                    } else {
                        $roleNames=$user_details->getRoles();
                        $user_details->removeRoles($roleNames);
                        User::whereId($request->id)->delete();
                        return ['status' => 'success', 'message' => 'User deleted successfully'];
                    }
                } else {
                    abort(404);
                }
            } else {
                abort(404);
            }
        }
    }
    public function reset2fa(Request $request)
    {
        $user_details = User::where('id', $request->id)->first();
        if ($user_details == null)
            return redirect()->back()->with('errorMessage', "User not found.");

        $user_details->google2fa_secret = null;
        $user_details['2fa_status'] = '0';
        $user_details->save();
        return redirect()->back()->with('doneMessage', "Two Factor Authentication Reset Successfully.");
    }
}
