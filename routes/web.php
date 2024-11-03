<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\FrontendController;
use \App\Http\Controllers\SettingController;
use \App\Http\Controllers\AdminController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ExpenseheadController;
use App\Http\Controllers\ExpenseSubheadController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TopUpController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\WithdrawController;
use App\Http\Controllers\ReportController;


Route::get('/', [FrontendController::class, 'login'])->name('index');
Route::get('/login', [FrontendController::class, 'login'])->name('frontend.login');
Route::post('/login-check', [FrontendController::class, 'loginCheck'])->name('frontend.loginCheck');

Route::middleware(['auth:web'])->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [FrontendController::class, 'logout'])->name('logout');


    //Profile Update
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::post('/update-profile', [AdminController::class, 'updatePro'])->name('update');
        Route::post('/update-password', [AdminController::class, 'updatePass'])->name('updatePass');
    });

    //Lead
    Route::resource('/lead', LeadController::class);
    Route::get('/lead-change-status-active/{id}', [LeadController::class, 'statusActive'])->name('lead.change-status.active');

    Route::get('/lead-change-status-inactive/{id}', [LeadController::class, 'statusInactive'])->name('lead.change-status.inactive');

    Route::get('/lead-make-customer/{id}', [LeadController::class, 'makeCustomer'])->name('lead.make-customer');
    Route::get('/lead-delete/{id}', [LeadController::class, 'destroy'])->name('lead.delete');

    //Customer
    Route::get('/customer-list', [LeadController::class, 'customerList'])->name('customer.index');
    Route::get('/customer-edit/{id}', [LeadController::class, 'customerEdit'])->name('customer.edit');
    Route::get('/customer-show/{id}', [LeadController::class, 'customerDetails'])->name('customer.show');
    Route::post('/customer-update/{id}', [LeadController::class, 'customerUpdate'])->name('customer.update');

    //Staff
    Route::resource('staff', StaffController::class);
    Route::get('/staff-delete/{id}', [StaffController::class, 'delete'])->name('staff.delete');


    // Staff role premissions //
    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/create', [RoleController::class, 'create'])->name('create');
        Route::post('/store', [RoleController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [RoleController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [RoleController::class, 'destroy'])->name('delete');
    });

    //Setting
    Route::prefix('setting')->name('setting.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::post('/store', [SettingController::class, 'store'])->name('store');
    });

    //project
    Route::resource('project', ProjectController::class);
    Route::get('/customer-name/ajax/{customer_name}', [ProjectController::class, 'getCustomerInfo'])->name('customerName.ajax');
    Route::get('/project-request-list', [ProjectController::class, 'requestindex'])->name('project.request-list');
    Route::get('/project-delete/{id}', [ProjectController::class, 'delete'])->name('project.delete');
    Route::get('/project-change-status/{id}', [ProjectController::class, 'changeStatus'])->name('project.change-status');
    Route::get('/project-approved/{id}', [ProjectController::class, 'changeApprove'])->name('project.approved');
    Route::get('/invoice/{id}', [ProjectController::class, 'invoice_download'])->name('invoice.download');


    //Payment
    Route::resource('payments', PaymentController::class);
    Route::get('/payments/delete/{id}', [PaymentController::class, 'delete'])->name('payments.delete');
    Route::get('/payment-request-list', [PaymentController::class, 'requestindex'])->name('payment.request-list');
    Route::get('/payment-approved/{id}', [PaymentController::class, 'changeApprove'])->name('payment.approved');
    Route::get('/project-payment/ajax/{project_name}', [PaymentController::class, 'getProjectPayment'])->name('project-payment.ajax');


    //Expense Head
    Route::prefix('expense-head')->name('expense-head.')->group(function () {
        Route::get('/', [ExpenseheadController::class, 'index'])->name('index');
        Route::get('/create', [ExpenseheadController::class, 'create'])->name('create');
        Route::post('/store', [ExpenseheadController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ExpenseheadController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ExpenseheadController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [ExpenseheadController::class, 'destroy'])->name('delete');
        Route::get('/active/{id}', [ExpenseheadController::class, 'active'])->name('active');
        Route::get('/inactive/{id}', [ExpenseheadController::class, 'inactive'])->name('in_active');
    });

    //Expense Sub-Head
    Route::resource('expense-sub-head', ExpenseSubheadController::class);
    Route::get('/expense-sub-head-delete/{id}', [ExpenseSubheadController::class, 'destroy'])->name('expense-sub-head.delete');
    Route::get('/expense-sub-head-active/{id}', [ExpenseSubheadController::class, 'subHeadactive'])->name('expense-sub-head.active');
    Route::get('/expense-sub-head-inactive/{id}', [ExpenseSubheadController::class, 'subHeadinactive'])->name('expense-sub-head.in_active');


    //Expense List
     Route::prefix('expense')->name('expense.')->group(function () {
        Route::get('/', [ExpenseController::class, 'index'])->name('index');
        Route::get('/request-list', [ExpenseController::class, 'requestIndex'])->name('request.list');
        Route::get('/create', [ExpenseController::class, 'create'])->name('create');
        Route::post('/store', [ExpenseController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ExpenseController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ExpenseController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [ExpenseController::class, 'destroy'])->name('delete');
        Route::get('/approved/{id}', [ExpenseController::class, 'changeApprove'])->name('approved');
        Route::get('/subheads/{expense_head_id}', [ExpenseController::class, 'getSubHeads']);
    });

    //top up
    Route::prefix('top-up')->name('top-up.')->group(function () {
        Route::get('/', [TopUpController::class, 'index'])->name('index');
        Route::get('/request-list', [TopUpController::class, 'requestindex'])->name('request-list');
        Route::get('/create', [TopUpController::class, 'create'])->name('create');
        Route::post('/store', [TopUpController::class, 'store'])->name('store');
        Route::get('request/edit/{id}', [TopUpController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [TopUpController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [TopUpController::class, 'destroy'])->name('delete');
        Route::get('/active/{id}', [TopUpController::class, 'active'])->name('active');
        Route::get('/inactive/{id}', [TopUpController::class, 'inactive'])->name('in_active');
    });

    //deposit
    Route::prefix('deposit')->name('deposit.')->group(function () {
        Route::get('/', [DepositController::class, 'index'])->name('index');
        Route::get('/request-list', [DepositController::class, 'requestIndex'])->name('request-list');
        Route::get('/create', [DepositController::class, 'create'])->name('create');
        Route::post('/store', [DepositController::class, 'store'])->name('store');
        Route::get('request/edit/{id}', [DepositController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [DepositController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [DepositController::class, 'destroy'])->name('delete');
        Route::get('/active/{id}', [DepositController::class, 'active'])->name('active');
        Route::get('/inactive/{id}', [DepositController::class, 'inactive'])->name('in_active');
    });

    //deposit
    Route::prefix('withdraw')->name('withdraw.')->group(function () {
        Route::get('/', [WithdrawController::class, 'index'])->name('index');
        Route::get('/request-list', [WithdrawController::class, 'requestIndex'])->name('request-list');
        Route::get('/create', [WithdrawController::class, 'create'])->name('create');
        Route::post('/store', [WithdrawController::class, 'store'])->name('store');
        Route::get('request/edit/{id}', [WithdrawController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [WithdrawController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [WithdrawController::class, 'destroy'])->name('delete');
        Route::get('/active/{id}', [WithdrawController::class, 'active'])->name('active');
        Route::get('/inactive/{id}', [WithdrawController::class, 'inactive'])->name('in_active');
    });
    Route::get('/account/ledger/list', [AdminController::class, 'AccountLedger'])->name('account.ledger.list');

    Route::prefix('report')->name('report.')->group(function () {
        Route::get('/payment', [ReportController::class, 'paymentReport'])->name('payment');
        Route::get('/payment-date-filter', [ReportController::class, 'paymentReportFilter'])->name('report-filter');
        Route::get('/project-wise-profit-loss', [ReportController::class, 'profitLoss'])->name('project-wise.profit-loss');
        Route::get('/project-wise-profit-loss-filter', [ReportController::class, 'profitLossFilter'])->name('profit-loss-filter');
        Route::get('/all-income/', [ReportController::class, 'allIncome'])->name('all-income');
        Route::get('/all-income-filter/', [ReportController::class, 'incomeFilter'])->name('all-income-filter');
        Route::get('/all-expense/', [ReportController::class, 'allExpense'])->name('all-expense');
        Route::get('/all-expense-filter/', [ReportController::class, 'expenseFilter'])->name('all-expense-filter');
        Route::get('/all-profit-loss/', [ReportController::class, 'allProfitLoss'])->name('all-profit-loss');
        Route::get('/all-profit-loss-filter/', [ReportController::class, 'allProfitLossFilter'])->name('all-profit-loss-filter');
    });
});

