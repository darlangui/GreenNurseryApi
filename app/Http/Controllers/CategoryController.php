<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        return (new CategoryCollection(Category::all()))->response()->setStatusCode(200);
    }

    public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category);
    }
    public function store(StoreCategoryRequest $request): \Illuminate\Http\JsonResponse
    {
        Category::create($request->validated());
        return response()->json("Category Created");
    }

    public function update(StoreCategoryRequest $request, Category $category): \Illuminate\Http\JsonResponse
    {
        $category->update($request->validated());
        return response()->json("Category Updated");
    }

    public function destroy(Category $category): \Illuminate\Http\JsonResponse
    {
        foreach ($category->plants as $plant) {
            if ($plant->path) {
                Storage::disk('public')->delete($plant->path);
            }
            $plant->delete();
        }
        $category->delete();
        return response()->json("Category and associated plants and images deleted");
    }
}
