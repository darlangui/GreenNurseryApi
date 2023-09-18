<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Resources\ClientCollection;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    public function index(): ClientCollection
    {
        return new ClientCollection(Client::all());
    }

    public function show(Client $client): ClientResource
    {
        return new ClientResource($client);
    }

    public function store(StoreClientRequest $request): \Illuminate\Http\JsonResponse
    {
        $validatedClient  = $request->validated();
        $validatedClient['password'] = Hash::make($request['password']);

        Client::create($validatedClient);
        return response()->json("Client Created");
    }

    public function update(StoreClientRequest $request, Client $client): \Illuminate\Http\JsonResponse
    {
        $validatedClient = $request->validated();

        if($request->has('password')){
            $validatedClient['password'] = Hash::make($validatedClient['password']);
        }

        $client->update($validatedClient);
        return response()->json("Client Updated");
    }

    public function destroy(Client $client): \Illuminate\Http\JsonResponse
    {
        $client->delete();
        return response()->json("Client Deleted");
    }

    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if(Auth::attempt($validatedData)){
            return response()->json([
                'message' => "Successful Login"
            ]);
        }

        return response()->json([
            'error' => "Invalid Credentials"
        ], 401);
    }
}
