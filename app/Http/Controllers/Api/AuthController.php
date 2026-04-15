<?php

namespace App\Http\Controllers\Api;

use App\DTOs\PermissionResponseDTO;
use App\DTOs\RoleResponseDTO;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
           // 'device_name' => 'required', // Opcional, para identificar o dispositivo
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['As credenciais fornecidas estão incorretas.'],
            ]);
        }

        // Cria o token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'role' => $user->roles->map(fn(Role $role) => RoleResponseDTO::fromEntity($role)),
            'permissions' => $user->getPermissionsViaRoles()->map(fn(Permission $permission) => PermissionResponseDTO::fromEntity($permission)),
        ]);
    }
    public function register(Request $request)
    {        
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'user' => $user,
        ]);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }

    public function createRole(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles',
        ]);
        $role = Role::create(['name' => $request->name]);
        return response()->json([
            'role' => $role,
        ]);
    }
    public function assignRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);
        $user = User::find($request->user_id);
        $role = Role::find($request->role_id);
        $user->assignRole($role);
        return response()->json([
            'message' => 'Role assigned successfully',
        ]);
    }
    public function removeRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);
        $user = User::find($request->user_id);
        $role = Role::find($request->role_id);
        $user->removeRole($role);
        return response()->json([
            'message' => 'Role removed successfully',
        ]);
    }
    public function getRoles(Request $request)
    {
        $roles = Role::all();
        return response()->json($roles->map(fn(Role $role) => RoleResponseDTO::fromEntity($role)));
    }
    public function getPermissions(Request $request)
    {
        $permissions = Permission::all();
        return response()->json([
            'permissions' => $permissions,
        ]);
    }
    public function createPermission(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions',
        ]);
        $permission = Permission::create(['name' => $request->name]);
        return response()->json([
            'permission' => $permission,
        ]);
    }
    public function assignPermission(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'permission_id' => 'required|exists:permissions,id',
        ]);
        $user = User::find($request->user_id);
        $permission = Permission::find($request->permission_id);
        $user->assignPermission($permission);
    }
    public function removePermission(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'permission_id' => 'required|exists:permissions,id',
        ]);
        $user = User::find($request->user_id);
        $permission = Permission::find($request->permission_id);
        $user->removePermission($permission);
    }
    public function getPermissionsForUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        $user = User::find($request->user_id);
        $permissions = $user->getPermissionsViaRoles();
        return response()->json([
            'permissions' => $permissions,
        ]);
    }

    public function assignPermissionToRole(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permission_id' => 'required|exists:permissions,id',
        ]);
        $role = Role::find($request->role_id);
        $permission = Permission::find($request->permission_id);
        $role->givePermissionTo($permission);
        return response()->json([
            'message' => 'Permission assigned to role successfully',
        ]);
    }
    public function removePermissionFromRole(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permission_id' => 'required|exists:permissions,id',
        ]);
        $role = Role::find($request->role_id);
        $permission = Permission::find($request->permission_id);
        $role->removePermission($permission);
        return response()->json([
            'message' => 'Permission removed from role successfully',
        ]);
    }
    public function getPermissionsForRole(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);
        $role = Role::find($request->role_id);
        $permissions = $role->getPermissionsViaRoles();
        return response()->json([
            'permissions' => $permissions,
        ]);
    }
}
