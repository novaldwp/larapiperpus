<?php

namespace App\Http\Controllers\api\v1\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Master\Bookshelf;
use App\Http\Resources\Master\Bookshelf\BookshelfResource;
use App\Http\Resources\Master\Bookshelf\BookshelfCollection;

class BookshelfController extends Controller
{
    public function index()
    {
        // fetch data from model bookshelf
        $book = Bookshelf::orderBy('id', 'DESC')
            ->get();

        // cek kondisi jika data tidak ada
        if (!$book)
        {
            // maka akan return sendempty()
            return $this->sendEmpty();
        }

        // jika data ada maka akan di return oleh json collection
        return $this->sendResponse(new BookshelfCollection($book), 1, 'Bookshelf');
    }

    public function store(Request $request)
    {
        // validasi form request
        $this->__validate($request);

        // jika validasi sukses maka create data untuk model bookshelf
        $book = Bookshelf::create([
            'name'          => $request->name,
            'category_id'   => $request->category_id
        ]);

        // jika berhasil akan mereturn json resource dan data yang diinput
        return $this->sendResponse(new BookshelfResource($book), 2, 'Bookshelf');
    }

    public function edit($id)
    {
        // cari data bookshelf dari id
        $book = $this->findBookshelfById($id);

        // cek kondisi jika tidak ditemukan
        if (!$book)
        {
            // maka akan mereturn sendNoData()
            return $this->sendNoData();
        }

        // jika ditemukan akan di return dengan json resource
        return $this->sendResponse(new BookshelfResource($book), 0, 'Bookshelf');
    }

    public function update(Request $request, $id)
    {
        // cek data bookself dari id
        $book = $this->findBookshelfById($id);

        // cek kondisi jika data tidak ada
        if (!$book)
        {
            // maka akan mereturn sendNoData()
            return $this->sendNoData();
        }

        // validasi form request
        $this->__validate($request);

        // jika validasi berhasil maka akan update data yang dicari
        $book->update([
            'name'          => $request->name,
            'category_id'   => $request->category_id
        ]);

        // lalu direturn dengan json resource data yang di update
        return $this->sendResponse(new BookshelfResource($book), 3, 'Bookshelf');
    }

    public function destroy($id)
    {
        // cari data bookshelf dari id
        $book = $this->findBookshelfById($id);

        // jika data tidak ditemukan
        if (!$book)
        {
            // maka akan mereturn sendNoData()
            return $this->sendNoData();
        }

        // jika ketemu, lalu lanjut ke fungsi delete()
        $book->delete();

        // lalu direturn dengan pesan
        return $this->sendDeleteSuccess("Bookshelf");
    }

    public function findBookshelfById($id)
    {
        // elouquent model bookshelf mencari data berdasarkan id
        $book = Bookshelf::where('id', $id)
            ->first();

        // kembalikan nilai pencarian
        return $book;
    }

    public function __validate($request)
    {
        // validation rules
        return $this->validate($request, [
            'name'          => 'required',
            'category_id'   => 'required|exists:tm_category,id'
        ]);
    }
}
