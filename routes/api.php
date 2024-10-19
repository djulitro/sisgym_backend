<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubcriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register/admin', [AuthController::class, 'registerAdmin'])->middleware('checkUserType:SuperAdmin');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/register', [AuthController::class, 'register'])->middleware('checkUserType:Admin,SuperAdmin');
    Route::get('/user', [AuthController::class,'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::group(['prefix' => 'subcription', 'middleware' => ['auth:sanctum', 'checkUserType:Admin,SuperAdmin']], function () {
    Route::get('/', [SubcriptionController::class, 'getAll']);
    Route::get('/{id}', [SubcriptionController::class, 'getById']);
    Route::post('/', [SubcriptionController::class, 'create']);
    Route::put('/{id}', [SubcriptionController::class, 'update']);
    Route::delete('/{id}', [SubcriptionController::class, 'delete']);
});

Route::group(['prefix' => 'payment', 'middleware' => ['auth:sanctum', 'checkUserType:Admin,SuperAdmin']], function () {
    Route::get('/{id}', [PaymentController::class, 'getById']);
    Route::get('/{startDate}/{endDate}', [PaymentController::class, 'getByDates']);
    Route::post('/', [PaymentController::class, 'create']);
    Route::put('/{id}', [PaymentController::class, 'update']);
    Route::delete('/{id}', [PaymentController::class, 'delete']);
    
    Route::get('/student/{studentId}', [PaymentController::class, 'getByStudent']);
});
