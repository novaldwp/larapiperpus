<?php

namespace App\Http\Controllers\API\v1\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Master\Category;
use App\Http\Resources\Master\CategoryResource;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::orderBy('id', 'DESC')->get();

        return $this->sendResponse(CategoryResource::collection($category), 'Retrieve category successfully');
    }

    public function store(Request $request)
    {
        $this->__validate($request);

        $category = Category::create([
            'name' => $request->name
        ]);

        return $this->sendResponse(new CategoryResource($category), 'Category inserted successfully');
    }

    public function edit($id)
    {
        $category = $this->findById($id);

        if (!$category)
        {
            return $this->sendNoData();
        }

        return $this->sendResponse(new CategoryResource($category), 'Get category successfully');
    }

    public function update(Request $request, $id)
    {
        $category = $this->findById($id);

        if (!$category)
        {
            return $this->sendNoData();
        }

        $this->__validate($request);

        $category->update([
            'name' => $request->name
        ]);

        return $this->sendResponse(new CategoryResource($category), 'Category updated successfully');
    }

    public function destroy($id)
    {
        $category = $this->findById($id);

        if (!$category)
        {
            return $this->sendNoData();
        }

        $category->delete();

        return $this->sendSuccess("Category deleted successfully");
    }

    public function findById($id)
    {
        $category = Category::find($id);

        return $category;
    }

    public function __validate($request)
    {
        return $this->validate($request, [
            'name' => 'required|unique:tm_category'
        ]);
    }
}
