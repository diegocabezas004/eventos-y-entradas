<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request)
    {
        if (auth()->user()->role_id !== 1) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $validated = $request->validate([
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'full_name' => 'required|string',
            'role_id' => 'required|exists:roles,id',
            'organization_id' => 'required|exists:organizations,id',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $user = UserController::create($validated);

        return response()->json($user, 201);
    }

    public function index()
    {
        return User::all();
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json($user);
    }

    public function destroy($id)
    {
        User::destroy($id);
        return response()->json(['message' => 'User deleted']);
    }
}
