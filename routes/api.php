<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\FreightController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PursheseController;
use App\Http\Controllers\UserController;


Route::group(['prefix' => 'v1'], function () {
   Route::apiResource('category', App\Http\Controllers\CategoryController::class);
    Route::apiResource('plant', PlantController::class);
    Route::apiResource('freight', FreightController::class);
    Route::apiResource('purshese', PursheseController::class);
    Route::post('/user', [UserController::class, 'store']);
   // Rotas para admin
   Route::group(['middleware' => ['auth:api', 'admin']], function () {
       Route::get('/user', [UserController::class, 'index']);
       Route::apiResource('category', CategoryController::class);
       Route::apiResource('plant', PlantController::class);
       Route::apiResource('freight', FreightController::class);
       Route::apiResource('purshese', PursheseController::class);
   });

      // Rotas para user normal
      Route::group(['middleware' => 'auth:api'], function () {
          Route::get('/user/{id}', [UserController::class, 'show']);
          Route::get('/purshese/{id}', [CategoryController::class, 'show']);
          Route::get('/purshese', [CategoryController::class, 'index']);
          Route::post('/purshese', [CategoryController::class, 'create']);
      });

         Route::get('/category/{category}', [CategoryController::class, 'show']);
         Route::get('/plant/{plant}', [PlantController::class, 'show']);
         Route::get('/freight/{freight}', [FreightController::class, 'show']);
         Route::get('/category', [CategoryController::class, 'index']);
         Route::get('/plant', [PlantController::class, 'index']);
         Route::get('/freight', [FreightController::class, 'index']);
         Route::get('/plants/images/{filename}', [PlantController::class, 'getPlantImage']);
});

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});
