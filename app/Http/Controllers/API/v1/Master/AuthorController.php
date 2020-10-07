<?php

namespace App\Http\Controllers\API\v1\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Master\Author;
use App\Http\Resources\Master\AuthorResource;

class AuthorController extends Controller
{
    public function index()
    {
        $author = Author::orderBy('id', 'DESC')->get();

        return $this->sendResponse(AuthorResource::collection($author), 'Retrieve author successfully');
    }

    public function store(Request $request)
    {
        $this->__validate($request);

        $author = Author::create([
            'name' => $request->name
        ]);

        return $this->sendResponse(new AuthorResource($author), 'Author inserted successfully');
    }

    public function edit($id)
    {
        $author = $this->findById($id);

        if (!$author)
        {
            return $this->sendNoData();
        }

        return $this->sendResponse(new AuthorResource($author), 'Get author successfully');
    }

    public function update(Request $request, $id)
    {
        $author = $this->findById($id);

        if (!$author)
        {
            return $this->sendNoData();
        }

        $this->__validate($request);

        $author->update([
            'name' => $request->name
        ]);

        return $this->sendSuccess('Author updated successfully');
    }

    public function destroy($id)
    {
        $author = $this->findById($id);

        if (!$author)
        {
            return $this->sendNodata();
        }

        $author->delete();

        return $this->sendSuccess('Author deleted successfully');
    }

    public function findById($id)
    {
        $author = Author::find($id);

        return $author;
    }

    public function __validate($request)
    {
        return $this->validate($request, [
            'name' => 'required'
        ]);
    }
}
