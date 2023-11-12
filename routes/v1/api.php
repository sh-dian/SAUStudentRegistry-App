<?php

use App\Http\Controllers\api\v1\AuthController;
use App\Http\Controllers\api\v1\StudentController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [AuthController::class, 'login']);

Route::middleware(
    'auth:api',
    // 'verified'
)->group(function () {
    // Logout
    Route::get('logout', [AuthController::class, 'logout']);

    Route::prefix('students')->group(function () {
        Route::post('import', [StudentController::class, 'importExcel']);
        Route::post('students', [StudentController::class, 'store']);
        Route::get('students', [StudentController::class, 'listStudent']);
        Route::put('{student}', [StudentController::class, 'update']);
        Route::get('{student}', [StudentController::class, 'show']);
        Route::delete('{student}', [StudentController::class, 'delete']);
    });
});
