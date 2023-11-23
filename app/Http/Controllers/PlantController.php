<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\StorePlantRequest;
use App\Http\Resources\PlantCollection;
use App\Http\Resources\PlantResource;
use App\Models\Plant;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class PlantController extends Controller
{
    public function index(): JsonResponse
    {
        return (new PlantCollection(Plant::all()))->response()->setStatusCode(200);
    }

    public function show(Plant $plant): PlantResource
    {
        return new PlantResource($plant);
    }

    public function store(StorePlantRequest $request): \Illuminate\Http\JsonResponse
    {
        $validatedPlant = $request->validated();

        if ($request->has('value') && !is_numeric($request->input('value'))) {
            return response()->json(['error' => 'The value field must be a number.'], 422);
        }

        if ($request->hasFile('path')) {
            $image = $request->file('path');

            $imageExtension = $image->getClientOriginalExtension();
            if (!in_array($imageExtension, ['jpeg', 'png', 'jpg', 'gif'])){
                return response()->json(['error' => 'The file extension is not supported.'], 422);
            }
            $imageName = Str::random(20) . '_' . time() . '.' . $imageExtension;

            $imagePath = $image->storeAs('images', $imageName, 'public');

            $validatedPlant['path'] = $imagePath;
        }

        Plant::create($validatedPlant);
        return response()->json("Plant Created");
    }

    public function update(StoreCategoryRequest $request, Plant $plant): \Illuminate\Http\JsonResponse
    {
        $validatedPlant = $request->validated();

        if ($request->has('value') && !is_numeric($request->input('value'))) {
            return response()->json(['error' => 'The value field must be a number.'], 422);
        }

        if ($request->hasFile('path')) {
            $image = $request->file('path');
            $imageExtension = $image->getClientOriginalExtension();

            if (!in_array($image->getClientOriginalExtension(), ['jpeg', 'png', 'jpg', 'gif']) || !$this->isImageValid($image)) {
                return response()->json(['error' => 'The file is not a valid image.'], 422);
            }

            if ($plant->path) {
                Storage::disk('public')->delete($plant->path);
            }

            $imageName = Str::random(20) . '_' . time() . '.' . $imageExtension;

            $imagePath = $image->storeAs('images', $imageName, 'public');
            $validatedPlant['path'] = $imagePath;
        }

        $plant->update($validatedPlant);
        return response()->json("Plant Updated");
    }


    public function destroy(Plant $plant): \Illuminate\Http\JsonResponse
    {
        if ($plant->path) {
            Storage::disk('public')->delete($plant->path);
        }
        $plant->delete();
        return response()->json("Plant Deleted");
    }

    public function getPlantImage($filename)
    {
        $path = storage_path('app/public/images/' . $filename);

        if (file_exists($path)) {
            return response()->file($path);
        }

        return response()->json(['error' => 'Image not found'], 404);
    }



    private function isImageValid($image): bool
    {
        $validExtensions = ['jpeg', 'png', 'jpg', 'gif'];
        $imageExtension = $image->getClientOriginalExtension();

        return in_array($imageExtension, $validExtensions) && @getimagesize($image->getRealPath()) !== false;
    }
}
