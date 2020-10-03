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

        return response()->json([
            'status'    => 1,
            'message'   => 'Data retrieved successfully',
            'data'      => AuthorResource::collection($author)
        ], 200);
    }

    public function store(Request $request)
    {
        $this->__validate($request);

        $name   = $request->name;

        $author = Author::create([
            'name' => $name
        ]);

        return $this->sendResponse(new AuthorResource($author), 'Author inserted successfully');
    }

    public function edit($id)
    {
        $author = Author::Find($id);

        if (!$author)
        {
            return $this->sendNoData();
        }

        return $this->sendResponse(new AuthorResource($author), 'Get data successfully');
    }

    public function update(Request $request, $id)
    {
        $author = Author::Find($id);

        if (!$author)
        {
            return $this->sendNoData();
        }

        $this->__validate($request);

        $name = $request->name;

        $author->update([
            'name' => $name
        ]);

        return $this->sendSuccess('Data update successfully');
    }

    public function destroy($id)
    {
        $author = Author::find($id);

        if (!$author)
        {
            return $this->sendNodata();
        }

        $author->delete();

        return $this->sendSuccess('Data delete successfully');
    }

    public function __validate($request)
    {
        return $this->validate($request, [
            'name' => 'required'
        ]);
    }
}
