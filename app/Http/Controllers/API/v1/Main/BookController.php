<?php

namespace App\Http\Controllers\API\v1\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Main\Book;
use App\Http\Resources\Main\Book\BookCollection;
use App\Http\Resources\Main\Book\BookResource;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class BookController extends Controller
{
    // bikin variable untuk menampung path
    private $oriPath;
    private $thumbPath;

    public function __construct()
    {
        $this->oriPath      = public_path('images/book');
        $this->thumbPath    = public_path('images/book/thumb');
    }
    public function index()
    {
        // fetch data dari model book
        $book = Book::orderBy('id', 'DESC')
            ->has('publisher')
            ->has('author')
            ->has('category')
            ->get();

        // cek kondisi jika fetch data kosong
        if ($book->isEmpty())
        {
            // return sendEmpty()
            return $this->sendEmpty();
        }

        // jika fetch data tidak kosong akan direturn json collection
        return $this->sendResponse(new BookCollection($book), 1, 'Book');
    }

    public function store(Request $request)
    {
        // validasi form request
        $this->__validate($request);

        // jika request mempunyai file image
        if ($request->hasFile('image')) {
            // tampung image ke variable $img
            $img       = $request->file('image');
            // jalankan function uploadImage() dengan mengirim $img
            $imageName = $this->uploadImage($img);
        }
        else {
            // jika tidak $imageName akan null
            $imageName  = "";
        }

        // buat data baru dengan model Book
        $book = Book::create([
            'code'              => $this->getCodeBook(),
            'isbn'              => ($request->isbn != "") ? $request->isbn:"-",
            'title'             => $request->title,
            'publication_year'  => $request->publication_year,
            'description'       => $request->description,
            'category_id'       => $request->category_id,
            'publisher_id'      => $request->publisher_id,
            'author_id'         => $request->author_id,
            'bookshelf_id'      => $request->bookshelf_id,
            'image'             => $imageName
        ]);

        // hasilnya akan direturn oleh json resource beserta data yang ditambahkan
        return $this->sendResponse(new BookResource($book), 2, 'Book');
    }

    public function edit($id)
    {
        // cari data berdasarkan id
        $book = $this->findBookById($id);

        // jika data tidak ada
        if (!$book)
        {
            // return sendNoData();
            return $this->sendNoData();
        }

        // jika data ada akan direturn json resource
        return $this->sendResponse(new BookResource($book), 0, 'Book');
    }

    public function update(Request $request, $id)
    {
        // cari data berdasarkan id
        $book = $this->findBookById($id);

        // jika data tidak ada
        if (!$book)
        {
            // return sendNoData()
            return $this->sendNoData();
        }

        // validasi form request
        $this->__validate($request);

        // cek apakah request mengirim file image
        if ($request->hasFile('image'))
        {
            // jika iya akan ditampung ke variable $img
            $img        = $request->file('image');

            // jalankan fungsi uploadImage dengan mengirimkan variable $img
            $imageName  = $this->uploadImage($img);
        }
        else {
            // jika tidak maka nama image menggunakan yang lama
            $imageName  = $book->image;
        }

        // jika member mempunyai image
        if ($book->image != "")
        {
            // maka file image yang ada di oriPath dan thumbPath akan dihapus
            File::delete($this->oriPath.'/'.$book->image);
            File::delete($this->thumbPath.'/'.$book->image);
        }

        // jalankan fungsi update sesuai data yang dicari tadi
        $book->update([
            'isbn'              => ($request->isbn != "") ? $request->isbn:"-",
            'title'             => $request->title,
            'publication_year'  => $request->publication_year,
            'description'       => $request->description,
            'category_id'       => $request->category_id,
            'publisher_id'      => $request->publisher_id,
            'author_id'         => $request->author_id,
            'bookshelf_id'      => $request->bookshelf_id,
            'image'             => $imageName
        ]);

        // return json resource
        return $this->sendResponse(new BookResource($book), 3, 'Book');
    }

    public function destroy($id)
    {
        // cari data berdasarkan id
        $book = $this->findBookById($id);

        // jika data tidak ditemukan
        if (!$book)
        {
            // return sendNoData()
            return $this->sendNoData();
        }

        // jika data ditemukan, jalankan fungsi delete
        $book->delete();

        // return message
        return $this->sendDeleteSuccess('Book');
    }

    public function findBookById($id)
    {
        // eloquent untuk mencari model Book berdasarkan id yang mempunyai publisher, author dan category
        $book = Book::where('id', $id)
            ->has('publisher')
            ->has('author')
            ->has('category')
            ->get();

        return $book;
    }

    public function getCodeBook()
    {
        // mencari data di model Book dimana code BK&
        $book = Book::where('code', 'like', 'BK%')
            ->count();

        // cek kondisi jika ketemu
        if ($book != 0)
        {
            // maka total data +1
            $count = $book + 1;
        }
        else {
            // jika tidak ada, maka nilainya 1
            $count = 1;
        }

        $digit = sprintf("%04s", $count);
        $code  = "BK".$digit;

        return $code;
    }

    public function uploadImage($img)
    {
        // cek apakah folder path tidak ada
        if (!File::isDirectory($this->oriPath))
        {
            // jika tidak ada, maka bikin folder path baru
            File::makeDirectory($this->oriPath, 0777, true, true);
            // beserta dengan thumbnail pathnya
            File::makeDirectory($this->thumbPath, 0777, true, true);
        }

        // rename image file yang dikirim dengan format waktu.uniqid.extension
        $imageName  = time().'.'.uniqid().'.'.$img->getClientOriginalExtension();
        // buat gambar baru dari lokasi file image yang di upload
        $image      = Image::make($img->getRealPath());
        // meresize gambar menjadi 180x180, dengan closure $cons
        $image->resize(180, 180, function($cons)
            {
                // constraint with aspectratio
                $cons->aspectRatio();
                // simpan ke path thumbnail
            })->save($this->thumbPath.'/'.$imageName);
            // simpan ke original path
        $image->save($this->oriPath.'/'.$imageName);

        return $imageName;
    }

    public function __validate($request)
    {
        // validation rule
        return $this->validate($request, [
            'title'             => 'required',
            'publication_year'  => 'required',
            'category_id'       => 'required|exists:tm_category,id',
            'publisher_id'      => 'required|exists:tm_publisher,id',
            'author_id'         => 'required|exists:tm_author,id',
            'bookshelf_id'      => 'required|exists:tm_bookshelf,id',
            'image'             => 'image|mimes:jpg,jpeg,png,gif,svg|max:2048'
        ]);
    }
}
