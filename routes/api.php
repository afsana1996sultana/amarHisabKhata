<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminApiController;
use App\Http\Controllers\Api\DepositController;
use App\Http\Controllers\Api\ExpenseHeadController;
use App\Http\Controllers\Api\ExpenseSubHeadController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\ProjectApiController;
use App\Http\Controllers\Api\StaffApiController;
use App\Http\Controllers\Api\PaymentApiController;
use App\Http\Controllers\Api\TopUpController;
use App\Http\Controllers\Api\WithdrawController;
use App\Http\Controllers\Api\ExpenseApiController;
use App\Http\Controllers\Api\ReportApiController;
use App\Http\Resources\Api\WithdrawController as ApiWithdrawController;
use App\Models\Setting;

//$prefix = Setting::where('prefix', '!=', '')->first()->prefix;

// Route::group(['prefix' => $prefix], function () {
Route::post('login', [AdminApiController::class, 'login']);
Route::post('logout', [AdminApiController::class, 'logout']);
// });



Route::group(['middleware' => 'auth:sanctum'], function () {

//Route::group(['prefix'], function () {

    Route::post('/profile-update', [AdminApiController::class, 'updateProfile']);
    Route::get('/get-profile', [AdminApiController::class, 'getProfile']);
    Route::post('/password-update', [AdminApiController::class, 'updatePassword']);
    Route::post('/site-setting', [AdminApiController::class, 'create']);
    //dashboard api
    Route::get('/get-dashboard-data', [AdminApiController::class, 'getDashboardData']);
    Route::get('/get-accountledger-data', [AdminApiController::class, 'getAccountLedger']);

    //Project Api
    Route::apiResource('/projects', ProjectApiController::class);
    Route::get('/current-project-list', [ProjectApiController::class, 'currentProjectList']);

    //Staff Api
    Route::apiResource('/staff', StaffApiController::class);

    //Payment Api
    Route::apiResource('/payments', PaymentApiController::class);


    //deposit Api
    Route::apiResource('/deposit', DepositController::class);
    Route::get('/depositRequest', [DepositController::class, 'depositRequest']);
    Route::get('/deposit/active/{id}', [DepositController::class, 'active']);
    Route::get('/deposit/inactive/{id}', [DepositController::class, 'inactive']);

    //expense-head api
    Route::apiResource('/expense-head', ExpenseHeadController::class);
    Route::get('/expense-head/active/{id}', [ExpenseHeadController::class, 'active']);
    Route::get('/expense-head/inactive/{id}', [ExpenseHeadController::class, 'inactive']);

    //expense-head api
    Route::apiResource('/expense-sub-head', ExpenseSubHeadController::class);
    Route::get('/expense-sub-head/active/{id}', [ExpenseSubHeadController::class, 'active']);
    Route::get('/expense-sub-head/inactive/{id}', [ExpenseSubHeadController::class, 'inactive']);

    //Expense Api
    Route::apiResource('/expenses', ExpenseApiController::class);
    Route::get('/expense-request-list', [ExpenseApiController::class, 'requestIndex']);
    Route::get('/expense-approve-request/{id}', [ExpenseApiController::class, 'approveExpense']);


    //leads Api
    Route::apiResource('/lead', LeadController::class);
    Route::get('/make-customer/{id}', [LeadController::class, 'makeCustomer']);
    Route::get('/customer-list', [LeadController::class, 'customerList']);
    Route::get('/lead/active/{id}', [LeadController::class, 'active']);
    Route::get('/lead/inactive/{id}', [LeadController::class, 'inactive']);
    Route::get('/customer-details/{id}', [LeadController::class, 'customerDetails']);


    //top-up Api
    Route::apiResource('/top-up', TopUpController::class);
    Route::get('/topUpRequest', [TopUpController::class, 'topUpRequest']);
    Route::get('/top-up/active/{id}', [TopUpController::class, 'active']);
    Route::get('/top-up/inactive/{id}', [TopUpController::class, 'inactive']);

    //withdraw Api
    Route::apiResource('/withdraw', WithdrawController::class);
    Route::get('/withdrawRequest', [WithdrawController::class, 'withdrawRequest']);
    Route::get('/withdraw/active/{id}', [WithdrawController::class, 'active']);
    Route::get('/withdraw/inactive/{id}', [WithdrawController::class, 'inactive']);

    //Report Api
     Route::prefix('report')->group(function () {
         Route::get('/payment-report-filter', [ReportApiController::class, 'paymentReportFilter']);
         Route::get('/project-wise-profit-loss-filter', [ReportApiController::class, 'profitLossReportFilter']);
         Route::get('/all-income-filter', [ReportApiController::class, 'allIncomeReportFilter']);
         Route::get('/all-expense-filter', [ReportApiController::class, 'allExpenseReportFilter']);
         Route::get('/all-profit-loss-filter', [ReportApiController::class, 'allProfitLossReportFilter']);
     });

});

//})->middleware('auth:sanctum');
