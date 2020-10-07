<?php

namespace App\Http\Controllers\API\v1\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Master\Publisher;
use App\Http\Resources\Master\PublisherResource;

class PublisherController extends Controller
{
    public function index()
    {
        $publisher = Publisher::orderBy('id', 'DESC')->get();

        return $this->sendResponse(PublisherResource::collection($publisher), 'Retrieve publisher successfully');
    }

    public function store(Request $request)
    {
        $this->__validate($request);

        $publisher = Publisher::create([
            'name'      => $request->name,
            'phone'     => $request->phone,
            'city'      => $request->city,
            'postcode'  => $request->postcode,
            'address'   => $request->address
        ]);

        return $this->sendResponse(new PublisherResource($publisher), 'Inserted publisher successfully');
    }

    public function edit($id)
    {
        $publisher = $this->findById($id);

        if (!$publisher)
        {
            return $this->sendNoData();
        }

        return $this->sendResponse(new PublisherResource($publisher), 'Get publisher successfully');
    }

    public function update(Request $request, $id)
    {
        $publisher = $this->findById($id);

        if (!$publisher)
        {
            return $this->sendNoData();
        }

        $this->__validate($request);

        $publisher->update([
            'name'      => $request->name,
            'phone'     => $request->phone,
            'city'      => $request->city,
            'postcode'  => $request->postcode,
            'address'   => $request->address
        ]);

        return $this->sendResponse(new PublisherResource($publisher), 'Update publisher successfully');
    }

    public function destroy($id)
    {
        $publisher = $this->findById($id);

        if (!$publisher)
        {
            return $this->sendNoData();
        }

        $publisher->delete();

        return $this->sendSuccess('Delete publisher successfully');
    }

    public function findById($id)
    {
        $publisher = Publisher::find($id);

        return $publisher;
    }

    public function __validate($request)
    {
        return $this->validate($request, [
            'name'      => 'required',
            'city'      => 'required',
            'postcode'  => 'required',
            'phone'     => 'required',
            'address'   => 'required'
        ]);
    }
}
