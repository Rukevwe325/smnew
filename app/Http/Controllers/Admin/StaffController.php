<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    /**
     * Admin creates a new staff account
     */
    public function createStaff(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|unique:users,email',
            'role_id' => ['required', 'integer', Rule::exists('roles', 'id')],
            'department_id' => ['required', 'integer', Rule::exists('departments', 'id')],
            'password' => 'nullable|string|min:8',  // Optional; if null, generate one
        ]);

        // Get the role to build staff_id prefix
        $role = Role::find($request->role_id);
        if (!$role) {
            return response()->json(['message' => 'Invalid role_id provided.'], 422);
        }

        // Generate staff ID: first 3 letters uppercase + 5 random digits
        $prefix = strtoupper(substr($role->name, 0, 3));
        $unique = false;
        $staffId = '';

        // Make sure staff_id is unique
        while (!$unique) {
            $staffId = $prefix . mt_rand(10000, 99999);
            $exists = User::where('staff_id', $staffId)->exists();
            if (!$exists) {
                $unique = true;
            }
        }

        // Generate a strong password if not provided
        $password = $request->password ?? Str::random(12);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $role->id,
            'department_id' => $request->department_id,
            'staff_id' => $staffId,
            'password' => Hash::make($password),
            'force_password_reset' => true,
        ]);

        // Return created user info + initial password for admin to relay securely
        return response()->json([
            'message' => 'Staff created successfully.',
            'staff' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $role->name,
                'department_id' => $user->department_id,
                'staff_id' => $user->staff_id,
                'initial_password' => $password,  // Important: Handle securely!
                'force_password_reset' => $user->force_password_reset,
            ]
        ], 201);
    }

    // You can add resetStaffPassword() here later as needed
}
