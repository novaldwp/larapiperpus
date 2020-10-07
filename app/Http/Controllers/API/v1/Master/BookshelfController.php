<?php

namespace App\Http\Controllers\api\v1\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Master\Bookshelf;
use App\Http\Resources\master\BookshelfResource;

class BookshelfController extends Controller
{
    public function index()
    {
        $book = Bookshelf::orderBy('id', 'DESC')->get();

        return $this->sendResponse(BookshelfResource::collection($book), 'Retrieve bookshelf successfully');
    }

    public function store(Request $request)
    {
        $this->__validate($request);

        $book = Bookshelf::create([
            'name' => $request->name,
            'category_id' => $request->category_id
        ]);

        return $this->sendResponse(new BookshelfResource($book), 'Inserted bookshelf successfully');
    }

    public function edit($id)
    {
        $book = $this->findById($id);

        if (!$book)
        {
            return $this->sendNoData();
        }

        return $this->sendResponse(new BookshelfResource($book), 'Get bookshelf successfully');
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
            'name'          => $request->name,
            'category_id'   => $request->category_id
        ]);

        return $this->sendResponse(new BookshelfResource($book), 'Update bookshelf successfully');
    }

    public function destroy($id)
    {
        $book = $this->findById($id);

        if (!$book)
        {
            return $this->sendNoData();
        }

        $book->delete();

        return $this->sendSuccess("Delete bookshelf successfully");
    }

    public function findById($id)
    {
        $book = Bookshelf::find($id);

        return $book;
    }

    public function __validate($request)
    {
        return $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required|exists:tm_category,id'
        ]);
    }
}
