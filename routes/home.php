<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\UserController;
use App\Http\Controllers\Home\CrewController;
use App\Http\Controllers\Home\DailyReportController;
use App\Http\Controllers\Home\ContractController;
use App\Http\Controllers\Home\AccountController;
use App\Http\Controllers\Home\ConsolidationController;
use App\Http\Controllers\Home\ConsolidationUnresolvedController;
use App\Http\Controllers\Home\PurchaseOrderController;
use App\Http\Controllers\Home\PurchaseOrderDetailController;

Route::get('',[HomeController::class,'index']);
Route::resource('users', UserController::class)->middleware('can:home.users.index')->names('home.users');
Route::resource('crews', CrewController::class)->middleware('can:home.crews.index')->names('home.crews');
Route::resource('dailyReports', DailyReportController::class)->middleware('can:home.dailyReport')->names('home.dailyReports');
Route::resource('contracts', ContractController::class)->middleware('can:home.contracts.index')->names('home.contracts');
Route::resource('accounts', AccountController::class)->middleware('can:home.accounts.index')->names('home.accounts');
Route::resource('consolidations', ConsolidationController::class)->middleware('can:home.consolidations')->names('home.consolidations');
Route::get('/consolidations/{crewId}/new/{monthYear}',[ConsolidationController::class,'new'])->name('consolidations.new');
Route::resource('consolidationsUnresolved', ConsolidationUnresolvedController::class)->middleware('can:home.consolidations')->names('home.consolidationsUnresolved');
// Route::get('home/consolidationsUnresolved/{consolidationsUnresolved}/new',[ConsolidationUnresolvedController::class,'new'])->middleware('can:home.consolidations')->name('home.consolidations.new');
Route::resource('purchaseOrders', PurchaseOrderController::class)->names('home.purchaseOrders');
Route::resource('purchaseOrderDetails', PurchaseOrderDetailController::class)->names('home.purchaseOrderDetails');