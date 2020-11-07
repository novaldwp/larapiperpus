<?php

namespace App\Http\Controllers\API\v1\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Master\Category;
use App\Model\Master\Bookshelf;
use App\Http\Resources\Master\Category\CategoryResource;
use App\Http\Resources\Master\Category\CategoryCollection;

class CategoryController extends Controller
{
    public function index()
    {
        // ambil data category join dengan bookshelf
        $category = Category::with(['bookshelf'])
            ->orderBy('id', 'DESC')
            ->get();

        // kalo datanya masih kosong nanti di return sama sendEmpty()
        if ($category->isempty())
        {
            // ini returnnya bertipe json dengan status dan message
            return $this->sendEmpty();
        }

        // kalo datanya ada bakal direturn dengan resource collection
        return $this->sendResponse(new CategoryCollection($category), 1, 'Category');
    }

    public function store(Request $request)
    {
        // validasi inputan, kalo emang validasinya gak ada gangguan bakal lanjut ke create
        $this->__validate($request);

        // create data baru
        $category = Category::create([
            'name' => $request->name
        ]);

        // kalo berhasil create bakal munculin pesan dan data yang diinput
        return $this->sendResponse(new CategoryResource($category), 2, 'Category');
    }

    public function show($id)
    {
        // mencari data dengan id terkait
        $category = $this->findCategoryById($id);

        // pengecekan jika data kosong
        if(!$category)
        {
            // jika data kosong maka akan direturn dengan sendNoData()
            return $this->sendNoData();
        }

        // jika datanya tersedia maka akan direturn dengan json resource
        return $this->sendResponse(new CategoryResource($category), 4, 'Category');
    }

    public function edit($id)
    {
        // mencari data dengan id terkait
        $category = $this->findCategoryById($id);

        // pengecekan jika data kosong
        if (!$category)
        {
            // jika data kosong maka akan direturn dengan sendNoData()
            return $this->sendNoData();
        }

        // jika datanya tersedia maka akan direturn dengan json resource
        return $this->sendResponse(new CategoryResource($category), 4, 'Category');
    }

    public function update(Request $request, $id)
    {
        // mencari data dengan id terkait
        $category = $this->findCategoryById($id);

        // pengecekan jika data kosong
        if (!$category)
        {
            // jika data kosong maka akan direturn dengan sendNoData()
            return $this->sendNoData();
        }

        // lakukan validasi data yang di request
        $this->__validate($request);

        // jika validasi true maka lanjut update data yang dicari tadi
        $category->update([
            'name' => $request->name
        ]);

        // jika update berhasil maka akan tampil status message dan data yang di update tadi
        return $this->sendResponse(new CategoryResource($category), 3, 'Category');
    }

    public function destroy($id)
    {
        // mencari data dengan id terkait
        $category = $this->findCategoryById($id);

        // pengecekan jika data kosong
        if (!$category)
        {
            // jika data kosong maka akan direturn dengan sendNoData()
            return $this->sendNoData();
        }

        // jika data ditemukan maka fungsi delete akan dieksekusi
        $category->delete();

        // jika delete berhasil maka akan direturn dengan status dan message
        return $this->sendDeleteSuccess('Category');
    }

    public function findCategoryById($id)
    {
        // mencari data dengan id, dan fitur relasi ini digunakan untuk method "SHOW"
        $category = Category::select('id', 'name')
        ->with([
            'bookshelf' => function($q) {
                $q->select('id', 'name', 'category_id');
            }
        ])
        ->where('id', $id)
        ->first();

        // return data yang di cari
        return $category;
    }

    public function __validate($request)
    {
        // ini callbaack validasi untuk CategoryController
        return $this->validate($request, [
            'name' => 'required|unique:tm_category'
        ]);
    }

    public function __checkEmpty($data)
    {
        // callback ini masih blum berfungsi, kalo $data kosong harusnya langsung return sendNoData().
        // Tapi kok ini malah kosong doangan
        if (!$data)
        {
            return $this->sendNoData();
        }

        return true;
        // return $data;
    }
}
