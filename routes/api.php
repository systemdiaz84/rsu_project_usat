<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\FamilyController;
use App\Http\Controllers\api\MapController;
use App\Http\Controllers\api\TreeController;
use App\Http\Controllers\api\TreephotoController;
use App\Models\Admin\Tree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::resource('/trees', TreeController::class)->names('api.trees');
Route::get('/trees_zone/{zone_id}', [TreeController::class,'trees_zone'])->name('api.trees_zone');
Route::get('/trees_families/{zone_id}', [TreeController::class,'trees_families'])->name('api.trees_families');
Route::resource('/treephoto', TreephotoController::class)->names('api.treephotos');


Route::resource('/maps', MapController::class)->names('api.map');
Route::get('/species_family/{family_id}',[FamilyController::class,'species_family'])->name('admin.species_family');
