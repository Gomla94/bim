<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\SubCategoryController;
use App\Http\Controllers\api\TransactionController;
use App\Http\Controllers\api\PaymentController;
use App\Http\Controllers\api\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Auth routes
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::group(['middleware' => 'auth:api'], function() {
    Route::group(['prefix' => 'admin', 'middleware' => 'authAdmin'], function() {
        Route::resource('transactions', TransactionController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('sub-categories', SubCategoryController::class);
        Route::post('transactions/{transaction}/add-payment', [PaymentController::class, 'store']);
        Route::post('basic-report', [ReportController::class, 'basic_report']);
        Route::post('monthly-report', [ReportController::class, 'monthly_report']);
    });
    Route::get('my-transactions/{transaction}', [TransactionController::class, 'my_transaction']);
});