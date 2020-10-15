<?php

namespace App\Http\Controllers\API\v1\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use App\User;
use App\Http\Resources\Main\UserResource;

class UserController extends Controller
{
    public function index()
    {
        $user = User::orderBy('id', 'DESC')->get();

        return $this->sendResponse(UserResource::collection($user), 'Retrieve user successfully');
    }

    public function store(Request $request)
    {
        $this->__validate($request);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role_id'   => $request->role_id
        ]);

        return $this->sendResponse(new UserResource($user), 'Insert user successfully');
    }

    public function edit($id)
    {
        $user = $this->findById($id);

        if (!$user)
        {
            return $this->sendNoData();
        }

        return $this->sendResponse(new UserResource($user), 'Get user successfully');
    }

    public function update(Request $request, $id)
    {
        $user = $this->findById($id);

        if (!$user)
        {
            return $this->sendNoData();
        }

        $this->__validate($request);

        $user->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role_id'   => $request->role_id
        ]);

        return $this->sendResponse(new UserResource($user), 'Update user successfully');
    }

    public function destroy($id)
    {
        $user = $this->findById($id);

        if (!$user)
        {
            return $this->sendNoData();
        }

        $user->delete();

        return $this->sendSuccess("Delete user successfully");
    }

    public function findById($id)
    {
        $user = User::find($id);

        return $user;
    }

    public function __validate($request)
    {
        return $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required|unique:users|email',
            'password'  => 'required|min:3',
            'role_id'   => 'required|exists:tm_role,id'
        ]);
    }
}
