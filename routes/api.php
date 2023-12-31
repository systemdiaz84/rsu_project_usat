<?php

use App\Http\Controllers\admin\PostController;
use App\Http\Controllers\admin\SpecieController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\EvolutionController;
use App\Http\Controllers\api\EvolutionPhotoController;
use App\Http\Controllers\api\FamilyController;
use App\Http\Controllers\api\GraphController;
use App\Http\Controllers\api\HomeController;
use App\Http\Controllers\api\HomeMembersController;
use App\Http\Controllers\api\MapController;
use App\Http\Controllers\api\ProcedureController;
use App\Http\Controllers\api\ProcedureTypeController;
use App\Http\Controllers\api\ResponsibleController;
use App\Http\Controllers\api\SpecieController as ApiSpecieController;
use App\Http\Controllers\api\StateController;
use App\Http\Controllers\api\TreeController;
use App\Http\Controllers\api\TreephotoController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\ZoneController;
use App\Models\admin\Family;
use App\Models\admin\Tree;
use App\Models\EvolutionPhoto;
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
Route::resource('/users', UserController::class)->names('api.users');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
 
//'auth:sanctum', 'permission'
Route::group(['middleware' => ['auth:sanctum']], function() {

    Route::post('/user/token', [UserController::class, 'save_token_device'])->name('api.user_token.save');
    Route::patch('/user/token', [UserController::class, 'disable_token_device'])->name('api.user_token.disable');
    Route::resource('/trees', TreeController::class)->names('api.trees');
    Route::get('/trees_zone/{zone_id}', [TreeController::class,'trees_zone'])->name('api.trees_zone');
    Route::get('/trees_families/{zone_id}', [TreeController::class,'trees_families'])->name('api.trees_families');
    Route::resource('/treephoto', TreephotoController::class)->names('api.treephotos');
    
    Route::resource('/graphs', GraphController::class)->names('api.graph');
    
    Route::resource('/maps', MapController::class)->names('api.map');
    Route::get('/species_family/{family_id}',[FamilyController::class,'species_family'])->name('admin.species_family');
    
    
    //------------------
    Route::resource('/procedures', ProcedureController::class)->names('api.procedure');
    Route::resource('/evolutions', EvolutionController::class)->names('api.evolution');
    Route::resource('/evolution_photos', EvolutionPhotoController::class)->names('api.evolution_photos');
    Route::resource('/families', FamilyController::class)->names('api.families');
    Route::resource('/proceduretypes', ProcedureTypeController::class)->names('api.proceduretypes');
    Route::resource('/states', StateController::class)->names('api.states');
    Route::resource('/responsibles', ResponsibleController::class)->names('api.responsible');
    Route::resource('/species', ApiSpecieController::class)->names('api.specie');
    Route::resource('/zones', ZoneController::class)->names('api.zone');
    
    
    Route::get('/evolutions/tree/{tree_id}', [EvolutionController::class, 'showEvolutionsByTree'])->name('api.evolutions_tree');
    Route::get('/procedures/tree/{tree_id}', [ProcedureController::class, 'showProceduresByTreeId']) ->name('api.procedures_tree');
    
    
    Route::get('/login/data/{email}', [UserController::class, 'data_email'])->name('api.data_email');
    
    Route::post('/home/request/{codeHome}', [HomeController::class, 'requestAccessHome'])->name('api.request_home');
    Route::get('/home/accept/{id}', [HomeController::class, 'accept'])->name('api.home.accept');
    Route::get('/home/reject/{id}', [HomeController::class, 'reject'])->name('api.home.reject');
    Route::get('/requests/pending', [UserController::class, 'pendingRequests'])->name('api.homemembers.pending');
    Route::get('/homemembers/accept/{id_home}/{id_member}', [HomeMembersController::class,'accept'])->name('api.homemembers.accept');
    Route::get('/homemembers/reject/{id_home}/{id_member}', [HomeMembersController::class,'reject'])->name('api.homemembers.reject');
    Route::get('/trees/accept/{id}', [TreeController::class,'accept'])->name('api.trees.accept');
    Route::get('/trees/reject/{id}', [TreeController::class,'reject'])->name('api.trees.reject');
    Route::get('/zone/search', [ZoneController::class, 'getZoneByCoordinates'])->name('api.zone_search');

    Route::get('/home/{user_id}', [HomeController::class, 'homeByUser']) ->name('api.homes_by_user');
    Route::post('/home', [HomeController::class, 'store']) ->name('api.home.store');
    Route::post('user/password', [UserController::class,'updatePassword'])->name('api.user.updatePassword');
    Route::get('/posts', [PostController::class, 'listApi'])->name('api.posts.index');
});

