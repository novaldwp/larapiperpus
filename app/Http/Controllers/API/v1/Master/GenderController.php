<?php

namespace App\Http\Controllers\API\v1\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Master\Gender;
use App\Http\Resources\Master\Gender\GenderCollection;
use App\Http\Resources\Master\Gender\GenderResource;

class GenderController extends Controller
{
    public function index()
    {
        // fetch data dari model gender dengan order DESC by ID
        $gender = Gender::orderBy('id', 'DESC')
            ->get();

        // cek kondisi jika gendernya tidak ada data
        if ($gender->isEmpty())
        {
            // maka akan direturn sendNoData()
            return $this->sendNoData();
        }

        // jika data data maka akan direturn dengan json collection
        return $this->sendResponse(new GenderCollection($gender), 1, 'Gender');
    }

    public function store(Request $request)
    {
        // validasi request form
        $this->__validate($request);

        // jika validasi berhasil lanjut ke create data baru
        $gender = Gender::create([
            'name' => $request->name
        ]);

        // dilanjut dengan return json resource
        return $this->sendResponse(new GenderResource($gender), 2, 'Gender');
    }

    public function edit($id)
    {
        // cari data by id
        $gender = $this->findGenderById($id);

        // cek kondisi jika data tidak ditemukan
        if (!$gender)
        {
            // maka akan direturn sendNoData()
            return $this->sendNoData();
        }

        // jika ditemukan akan di return dengan json resource
        return $this->sendResponse(new GenderResource($gender), 0, 'Gender');
    }

    public function update(Request $request, $id)
    {
        // cari data by id
        $gender = $this->findGenderById($id);

        // cek kondisi jika data tidak ditemukan
        if (!$gender)
        {
            // maka akan direturn sendNoData()
            return $this->sendNoData();
        }

        // dilanjuti dengan validasi form request jika ditemukan
        $this->__validate($request);

        // update data gender
        $gender->update([
            'name' => $request->name
        ]);

        // lalu direturn dengan json resource
        return $this->sendResponse(new GenderResource($gender), 3, 'Gender');
    }

    public function destroy($id)
    {
        // cari data by id
        $gender = $this->findGenderById($id);

        // cek kondisi jika data tidak ditemukan
        if (!$gender)
        {
            // maka akan direturn sendNoData()
            return $this->sendNoData();
        }

        // delete data yang ditemukan tadi
        $gender->delete();

        // lalu direturn dengan json response
        return $this->sendDeleteSuccess("Gender");
    }

    public function findGenderById($id)
    {
        // eloquent mencari data dari model gender berdasarkan id
        $gender = Gender::where('id', $id)
            ->first();

        // return data
        return $gender;
    }

    public function __validate($request)
    {
        // rule validation
        return $this->validate($request, [
            'name' => 'required'
        ]);
    }
}
