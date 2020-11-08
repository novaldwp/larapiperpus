<?php

namespace App\Http\Controllers\API\v1\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Master\Publisher;
use App\Http\Resources\Master\Publisher\PublisherResource;
use App\Http\Resources\Master\Publisher\PublisherCollection;

class PublisherController extends Controller
{
    public function index()
    {
        // fetch data from model publisher
        $publisher = Publisher::orderBy('id', 'DESC')
            ->get();

        // pengecekan apakaah data publisher kosong
        if ($publisher->isEmpty())
        {
            // jika iya maka akan direturn dengan sendEmpty()
            return $this->sendEmpty();
        }

        // jika data tersedia maka akan direturn dengan json collection
        return $this->sendResponse(new PublisherCollection($publisher), 1, 'Publisher');
    }

    public function store(Request $request)
    {
        // validasi form request
        $this->__validate($request);

        // jika validasi berhasil maka langsung create data ke model
        $publisher = Publisher::create([
            'name'      => $request->name,
            'phone'     => $request->phone,
            'city'      => $request->city,
            'postcode'  => $request->postcode,
            'address'   => $request->address
        ]);

        // jika sudah selesai maka langsung return json resource
        return $this->sendResponse(new PublisherResource($publisher), 2, 'Publisher');
    }

    public function edit($id)
    {
        // cek data berdasarkan id
        $publisher = $this->findPublisherById($id);

        // cek kondisi jika data tidak tersedia
        if (!$publisher)
        {
            // maka akan direturn oleh sendNoData()
            return $this->sendNoData();
        }

        // jika data tersedia akan direturn oleh json resource
        return $this->sendResponse(new PublisherResource($publisher), 0, 'Publisher');
    }

    public function update(Request $request, $id)
    {
        // cek data berdasarkan id
        $publisher = $this->findPublisherById($id);

        // cek kondisi jika data tidak tersedia
        if (!$publisher)
        {
            // maka akan direturn oleh sendNoData()
            return $this->sendNoData();
        }

        // validasi form request
        $this->__validate($request);

        // jika validasi berhasil maka update data yang tersedia
        $publisher->update([
            'name'      => $request->name,
            'phone'     => $request->phone,
            'city'      => $request->city,
            'postcode'  => $request->postcode,
            'address'   => $request->address
        ]);

        // lanjut dengan return json resource beserta data yang sudah di update
        return $this->sendResponse(new PublisherResource($publisher), 3, 'Publisher');
    }

    public function destroy($id)
    {
        // cek data berdasarkan id
        $publisher = $this->findPublisherById($id);

        // cek kondisi jika data tidak tersedia
        if (!$publisher)
        {
            // maka akan direturn sendNoData()
            return $this->sendNoData();
        }

        // jika data tersedia lanjut pemanggilan fungsi delete()
        $publisher->delete();

        // jika sudah di delete return message
        return $this->sendDeleteSuccess('Publisher');
    }

    public function findPublisherById($id)
    {
        // eloquent untuk mencari data publisher berdasarkan id
        $publisher = Publisher::where('id', $id)
            ->first();

        // kembalikan hasil pencarian
        return $publisher;
    }

    public function __validate($request)
    {
        // validation rule
        return $this->validate($request, [
            'name'      => 'required',
            'city'      => 'required',
            'postcode'  => 'required',
            'phone'     => 'required',
            'address'   => 'required'
        ]);
    }
}
