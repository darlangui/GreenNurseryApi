<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFreightRequest;
use App\Http\Resources\FreightCollection;
use App\Http\Resources\FreightResource;
use App\Models\Freight;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FreightController extends Controller
{
    public function index(): JsonResponse
    {
        return (new FreightCollection(Freight::all()))->response()->setStatusCode(200);
    }

    public function show(Freight $freight): FreightResource
    {
        return new FreightResource($freight);
    }

    public function store(StoreFreightRequest $request): \Illuminate\Http\JsonResponse
    {
        $validatedFreight = $request->validated();

        if ($request->has('value') && !is_numeric($request->input('value'))) {
            return response()->json(['error' => 'The value field must be a number.'], 422);
        }

        Freight::create($validatedFreight);
        return response()->json("Freight Created");
    }

    public function update(StoreFreightRequest $request, Freight $freight): \Illuminate\Http\JsonResponse
    {
        $validatedFreight = $request->validated();

        if ($request->has('value') && !is_numeric($request->input('value'))) {
            return response()->json(['error' => 'The value field must be a number.'], 422);
        }

        $freight->update($validatedFreight);
        return response()->json("Freight Updated");
    }

    public function destroy(Freight $freight): \Illuminate\Http\JsonResponse
    {
        $freight->delete();
        return response()->json("Freight Deleted");
    }
}
