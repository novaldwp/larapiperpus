<?php

namespace App\Http\Controllers\API\v1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3',
            'role_id' => 'required|exists:tm_role,id'
        ]);

        $name       = $request->name;
        $email      = $request->email;
        $password   = $request->password;
        $role_id    = $request->role_id;

        $user       = User::create([
            'name'      => $name,
            'email'     => $email,
            'password'  => Hash::make($password),
            'role_id'   => $role_id
        ]);

        return response()->json([
            'status'    => 1,
            'message'   => 'User registered successfully',
            'data'      => $user
        ]);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        $email      = $request->email;
        $password   = $request->password;

        $user   = User::where('email', $email)->first();
        if (!Hash::check($password, $user->password))
        {
            return response()->json([
                'status'    => 0,
                'message'   => 'Invalid email or password, please try again'
            ], 404);
        }

        return response()->json([
            'status'    => 1,
            'message'   => 'User login successfully',
            'data'      => $user->createToken('this is secret key iv')->plainTextToken
        ]);
    }

    public function logout()
    {
        $user = request()->user();
        $user->tokens()->delete();

        return response()->json([
            'status'    => 1,
            'message'   => 'User logout successfully'
        ]);
    }
}
