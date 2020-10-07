<?php

namespace App\Http\Controllers\API\v1\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Master\Gender;
use App\Http\Resources\Master\GenderResource;

class GenderController extends Controller
{
    public function index()
    {
        $gender = Gender::orderBy('id', 'DESC')->get();

        return $this->sendResponse(GenderResource::collection($gender), 'Retrieve gender successfully');
    }

    public function store(Request $request)
    {
        $this->__validate($request);

        $gender = Gender::create([
            'name' => $request->name
        ]);

        return $this->sendResponse(new GenderResource($gender), 'Gender inserted successfully');
    }

    public function edit($id)
    {
        $gender = $this->findById($id);

        if (!$gender)
        {
            return $this->sendNoData();
        }

        return $this->sendResponse(new GenderResource($gender), 'Get gender successfully');
    }

    public function update(Request $request, $id)
    {
        $gender = $this->findById($id);

        if (!$gender)
        {
            return $this->sendNoData();
        }

        $gender->update([
            'name' => $request->name
        ]);

        return $this->sendResponse(new GenderResource($gender), 'Update gender successfully');
    }

    public function destroy($id)
    {
        $gender = $this->findById($id);

        if (!$gender)
        {
            return $this->sendNoData();
        }

        $gender->delete();

        return $this->sendSuccess("Delete gender successfully");
    }

    public function findById($id)
    {
        $gender = Gender::find($id);

        return $gender;
    }

    public function __validate($request)
    {
        return $this->validate($request, [
            'name' => 'required'
        ]);
    }
}
