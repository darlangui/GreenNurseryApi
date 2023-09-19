<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(): UserCollection
    {
        return new UserCollection(User::all());
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $validatedUser  = $request->validated();
        $validatedUser['password'] = Hash::make($request['password']);

        $createdUser = User::create($validatedUser);
        return response()->json(["message" => "User Created", "data" => $createdUser], 201);
    }

    public function show(int $id): UserResource | JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(["message" => "User not found"], 404);
        }

        return new UserResource($user);
    }
}
