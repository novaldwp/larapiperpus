<?php

namespace App\Http\Controllers\API\v1\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Main\Book;
use App\Http\Resources\Main\BookResource;

class BookController extends Controller
{
    public function index()
    {
        $book = Book::orderBy('id', 'DESC')->get();

        return $this->sendResponse(BookResource::collection($book), 'Retrieve book successfully');
    }

    public function store(Request $request)
    {
        $this->__validate($request);

        $book = Book::create([
            'code'              => $this->getCodeBook(),
            'isbn'              => ($request->isbn != "") ? $request->isbn:"-",
            'title'             => $request->title,
            'publication_year'  => $request->publication_year,
            'description'       => $request->description,
            'category_id'       => $request->category_id,
            'publisher_id'      => $request->publisher_id,
            'author_id'         => $request->author_id,
            'bookshelf_id'      => $request->bookshelf_id
        ]);

        return $this->sendResponse(new BookResource($book), 'Insert book successfully');
    }

    public function edit($id)
    {
        $book = $this->findById($id);

        if (!$book)
        {
            return $this->sendNoData();
        }

        return $this->sendResponse(new BookResource($book), 'Get book successfully');
    }

    public function update(Request $request, $id)
    {
        $book = $this->findById($id);

        if (!$book)
        {
            return $this->sendNoData();
        }

        $this->__validate($request);

        $book->update([
            'isbn'              => ($request->isbn != "") ? $request->isbn:"-",
            'title'             => $request->title,
            'publication_year'  => $request->publication_year,
            'description'       => $request->description,
            'category_id'       => $request->category_id,
            'publisher_id'      => $request->publisher_id,
            'author_id'         => $request->author_id,
            'bookshelf_id'      => $request->bookshelf_id
        ]);

        return $this->sendResponse(new BookResource($book), 'Update book successfully');
    }

    public function destroy($id)
    {
        $book = $this->findById($id);

        if (!$book)
        {
            return $this->sendNoData();
        }

        $book->delete();

        return $this->sendSuccess('Delete book successfully');
    }

    public function findById($id)
    {
        $book = Book::find($id);

        return $book;
    }

    public function getCodeBook()
    {
        $book = Book::where('code', 'like', 'BK%')->count();

        if ($book != 0)
        {
            $count = $book + 1;
        }
        else {
            $count = 1;
        }

        $digit = sprintf("%04s", $count);
        $code  = "BK".$digit;

        return $code;
    }

    public function __validate($request)
    {
        return $this->validate($request, [
            'title'             => 'required',
            'publication_year'  => 'required',
            'category_id'       => 'required|exists:tm_category,id',
            'publisher_id'      => 'required|exists:tm_publisher,id',
            'author_id'         => 'required|exists:tm_author,id',
            'bookshelf_id'      => 'required|exists:tm_bookshelf,id'
        ]);
    }
}
