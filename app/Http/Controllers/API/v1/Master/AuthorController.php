<?php

namespace App\Http\Controllers\API\v1\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Master\Author;
use App\Http\Resources\Master\Author\AuthorResource;
use App\Http\Resources\Master\Author\AuthorCollection;

class AuthorController extends Controller
{
    public function index()
    {
        // fetch data dari model author order DESC by ID
        $author = Author::orderBy('id', 'DESC')
            ->get();

        // cek kondisi
        if ($author->isEmpty())
        {
            // kalo authornya gak ada data maka akan dikirim return sendEmpty()
            return $this->sendEmpty();
        }

        // jika datanya ada maka akan direturn dengan json collection
        return $this->sendResponse(new AuthorCollection($author), 1, 'Author');
    }

    public function store(Request $request)
    {
        // validasi request form
        $this->__validate($request);

        // jika validasi berjalan lancar maka akan create data baru
        $author = Author::create([
            'name' => $request->name
        ]);

        // jika create sukses akan direturn message dengan data yang diinput
        return $this->sendResponse(new AuthorResource($author), 2, 'Author');
    }

    public function edit($id)
    {
        // cari data author by id
        $author = $this->findAuthorById($id);

        // cek kondisi
        if (!$author)
        {   // jika data tidak ditemukan akan direturn sendNoData()
            return $this->sendNoData();
        }

        // jika ditemuka maka akan direturn dengan json resource
        return $this->sendResponse(new AuthorResource($author), 0, 'Author');
    }

    public function update(Request $request, $id)
    {
        // cari data author by id
        $author = $this->findAuthorById($id);

        // cek kondisi
        if (!$author)
        {
            // jika data tidak ditemukan akan direturn sendNoData()
            return $this->sendNoData();
        }

        // jika data ditemukan akan lanjut divalidasi
        $this->__validate($request);

        // jika validasi berhasil maka data akan di update
        $author->update([
            'name' => $request->name
        ]);

        // dilanjut dengan return json resource
        return $this->sendResponse(new AuthorResource($author), 3, 'Author');
    }

    public function destroy($id)
    {
        // cari author by id
        $author = $this->findAuthorById($id);

        // cek kondisi
        if (!$author)
        {
            // jika data tidak ditemukan akan direturn sendNoData()
            return $this->sendNodata();
        }

        // jika data ditemukan maka langsung ke proses delete
        $author->delete();

        // dilanjut dengan return json resource
        return $this->sendDeleteSuccess('Author');
    }

    public function findAuthorById($id)
    {
        // eloquent untuk mencari data berdasasrkan id
        $author = Author::where('id', $id)
            ->first();

        return $author;
    }

    public function __validate($request)
    {
        // rules validation
        return $this->validate($request, [
            'name' => 'required'
        ]);
    }
}
