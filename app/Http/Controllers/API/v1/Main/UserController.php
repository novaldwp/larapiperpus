<?php

namespace App\Http\Controllers\API\v1\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use App\User;
use App\Http\Resources\Main\User\UserCollection;
use App\Http\Resources\Main\User\UserResource;

class UserController extends Controller
{
    public function index()
    {
        // fetch data dari model User
        $user = User::orderBy('id', 'DESC')
            ->get();

        // cek kondisi jika $user kosong
        if ($user->isEmpty())
        {
            // return sendEmpty()
            return $this->sendEmpty();
        }

        // jika tidak kosong akan direturn oleh json collection
        return $this->sendResponse(new UserCollection($user), 1, 'User');
    }

    public function store(Request $request)
    {
        // validasi form request
        $this->__validate($request);

        // jika validasi berhasil maka create data baru
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role_id'   => $request->role_id
        ]);

        // direturn oleh json resource yang berisi message + data yang diinput
        return $this->sendResponse(new UserResource($user), 2, 'User');
    }

    public function edit($id)
    {
        // cari data berdasarkan id
        $user = $this->findUserById($id);

        // cek kondisi jika data tidak ada
        if (!$user)
        {
            // maka akan direturn sendNoData()
            return $this->sendNoData();
        }

        // jika data ada akan direturn oleh json resource
        return $this->sendResponse(new UserResource($user), 0, 'User');
    }

    public function update(Request $request, $id)
    {
        // cari data berdasarkan id
        $user = $this->findUserById($id);

        // cek kondisi jika data tidak ada
        if (!$user)
        {
            // maka akan direturn sendNoData()
            return $this->sendNoData();
        }

        // validasi form request
        $this->__validate($request);

        // jika validasi berhasil maka update data yang dicari
        $user->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role_id'   => $request->role_id
        ]);

        // ketika berhasil akan direturn oleh json resource berupa message + data yang diupdate
        return $this->sendResponse(new UserResource($user), 3, 'User');
    }

    public function destroy($id)
    {
        // cari data berdasarkan id
        $user = $this->findUserById($id);

        // cek kondisi jika data tidak ada
        if (!$user)
        {
            // return sendNoData()
            return $this->sendNoData();
        }

        // jika data ada, maka akan langsung didelete
        $user->delete();

        // return message
        return $this->sendDeleteSuccess("User");
    }

    public function findUserById($id)
    {
        // eloquent untuk mencari data berdasarkan id di model User
        $user = User::where('id', $id)
            ->first();

        // return data
        return $user;
    }

    public function __validate($request)
    {
        // cek kondisi jika methodnya PUT
        if ($request->method() == "PUT") {
            // maka validasi untuk email seperti ini
            $email  = 'required|email';
        }
        else {
            // jika tidak akan seperti ini
            $email = 'required|unique:users|email';
        }

        // validation rules
        return $this->validate($request, [
            'name'      => 'required',
            'email'     => $email,
            'password'  => 'required|min:3',
            'role_id'   => 'required|exists:tm_role,id'
        ]);
    }
}
