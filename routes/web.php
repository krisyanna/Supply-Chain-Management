<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransferReportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ForecastingController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\LogisticsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SupplierController;

/*
|--------------------------------------------------------------------------
| Home  
|--------------------------------------------------------------------------
*/

Route::view('/', 'pages.home')->name('home');
Route::view('/welcome', 'pages.home')->name('welcome');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Forecasting
|--------------------------------------------------------------------------
*/

Route::get('/forecasting', [ForecastingController::class, 'index'])->name('forecasting');
Route::get('/forecasting/historical', [ForecastingController::class, 'historicalSales'])->name('forecasting.historical');
Route::get('/forecasting/demand', [ForecastingController::class, 'forecastDemand'])->name('forecasting.demand');

/*
|--------------------------------------------------------------------------
| Sales
|--------------------------------------------------------------------------
*/

Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');
Route::post('/sales', [SalesController::class, 'store'])->name('sales.store');

/*
|--------------------------------------------------------------------------
| Procurement
|--------------------------------------------------------------------------
*/

Route::get('/suppliers', [SupplierController::class, 'index'])
    ->name('suppliers.index');

Route::resource('purchase-orders', PurchaseOrderController::class);

/*
|--------------------------------------------------------------------------
| Logistics
|--------------------------------------------------------------------------
*/

Route::get('/logistics', [LogisticsController::class, 'index'])->name('logistics.dashboard');
Route::post('/shipments', [LogisticsController::class, 'store'])->name('shipments.store');
Route::put('/shipments/{id}', [LogisticsController::class, 'update'])->name('shipments.update');
Route::delete('/shipments/{id}', [LogisticsController::class, 'destroy'])->name('shipments.destroy');

/*
|--------------------------------------------------------------------------
| Inventory
|--------------------------------------------------------------------------
*/

Route::get('/inventory', function () {return view('inventory');})->name('inventory');
Route::get('/warehouse', function () {return view('warehouse');})->name('warehouse');
Route::resource('products', ProductController::class);
Route::get('/transfers', [TransferReportController::class, 'index'])->name('transfers.report');



/*
|--------------------------------------------------------------------------
| Reports
|--------------------------------------------------------------------------
*/

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

Route::get('/reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');
Route::get('/reports/procurements', [ReportController::class, 'procurements'])->name('reports.procurements');
Route::get('/reports/logistics', [ReportController::class, 'logistics'])->name('reports.logistics');
Route::get('/reports/warehouse', [ReportController::class, 'warehouse'])->name('reports.warehouse');
Route::get('/reports/financial', [ReportController::class, 'financial'])->name('reports.financial');
Route::get('/reports/builder', [ReportController::class, 'builder'])->name('reports.builder');

Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
Route::get('/reports/{report}/edit', [ReportController::class, 'edit'])->name('reports.edit');
Route::put('/reports/{report}', [ReportController::class, 'update'])->name('reports.update');