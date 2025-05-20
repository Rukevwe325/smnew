<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // STEP 3: Generate Staff ID
    private function generateStaffId($roleName)
    {
        $prefix = strtoupper(substr($roleName, 0, 3)); // e.g., "NUR" for Nurse
        $randomNumber = mt_rand(10000, 99999);
        return $prefix . $randomNumber;
    }

    // STEP 4: Admin creates staff
    public function createStaff(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'role_id' => 'required|exists:roles,id',
            'department_id' => 'required|exists:departments,id',
        ]);

        $role = Role::findOrFail($validated['role_id']);
        $staffId = $this->generateStaffId($role->name);
        $defaultPassword = Str::random(10);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role_id' => $validated['role_id'],
            'department_id' => $validated['department_id'],
            'staff_id' => $staffId,
            'password' => bcrypt($defaultPassword),
            'force_password_reset' => true
        ]);

        return response()->json([
            'message' => 'Staff created',
            'staff_id' => $staffId,
            'default_password' => $defaultPassword
        ], 201);
    }
}
