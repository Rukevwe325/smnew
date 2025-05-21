<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Staff login using staff_id and password
    public function login(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('staff_id', $request->staff_id)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        if ($user->force_password_reset) {
            return response()->json([
                'message' => 'Password reset required',
                'force_password_reset' => true,
                'token' => $user->createToken('temp-login')->plainTextToken
            ]);
        }

        return response()->json([
            'message' => 'Login successful',
            'token' => $user->createToken('staff-login')->plainTextToken
        ]);
    }

    // Force change of password on first login
    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = auth()->user();
        $user->password = bcrypt($request->password);
        $user->force_password_reset = false;
        $user->save();

        return response()->json(['message' => 'Password updated successfully']);
    }

    // Admin resets password for a staff (restricted to role_id == 1)
    public function resetStaffPassword(Request $request)
    {
        $authUser = auth()->user();

        // 🔐 Restrict to Admin only
        if ($authUser->role_id !== 1) {
            return response()->json(['message' => 'Unauthorized – Only admin can reset passwords'], 403);
        }

        $request->validate([
            'staff_id' => 'required|exists:users,staff_id'
        ]);

        $user = User::where('staff_id', $request->staff_id)->first();
        $newPassword = Str::random(10);

        $user->password = bcrypt($newPassword);
        $user->force_password_reset = true;
        $user->save();

        return response()->json([
            'message' => 'Password reset successfully',
            'staff_id' => $user->staff_id,
            'new_password' => $newPassword
        ]);
    }
}
