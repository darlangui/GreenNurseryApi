<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePursheseRequest;
use App\Http\Resources\PursheseCollection;
use App\Http\Resources\PursheseResource;
use App\Models\Freight;
use App\Models\Plant;
use App\Models\Purshese;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PursheseController extends Controller
{
    public function index(): JsonResponse
    {
        return (new PursheseCollection(Purshese::all()))->response()->setStatusCode(200);
    }

    public function show(Purshese $purshese){
        return new PursheseResource($purshese);
    }

    public function store(StorePursheseRequest $request){
        $validatedPurshese = $request->validated();

        $plantName = $validatedPurshese['plant_name'];
        $plant = Plant::where('name', $plantName)->first();

        $stateName = $validatedPurshese['freight_state'];
        $state = Freight::where('state', $stateName)->first();

        $validatedPurshese['value'] = ($plant->value * $validatedPurshese['mount']) + $state->value;

        Purshese::create($validatedPurshese);
        return response()->json("Purshese Created");
    }

    public function update(StorePursheseRequest $request, Purshese $purshese){
        $validatedPurshese = $request->validated();

        $plantName = $validatedPurshese['plant_name'];
        $plant = Plant::where('name', $plantName)->first();

        $stateName = $validatedPurshese['freight_state'];
        $state = Freight::where('state', $stateName)->first();

        $validatedPurshese['value'] = ($plant->value * $validatedPurshese['mount']) + $state->value;

        $purshese->update($validatedPurshese);
        return response()->json("Purshese Updated");
    }

    public function destroy(Purshese $purshese){
        $purshese->delete();
        return response()->json("Purshese Deleted");
    }
}
