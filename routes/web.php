<?php

use App\Http\Controllers;
use App\Http\Controllers\welcome;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\logincanvas;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RemoveOCVFlag;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Company\SaleController;
use App\Http\Controllers\Company\CashinController;
use App\Http\Controllers\Company\CompanyDashboard;
use App\Http\Controllers\Company\AccountController;
use App\Http\Controllers\Company\PaymentController;
use App\Http\Controllers\Company\ProductController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Company\CategoryController;
use App\Http\Controllers\Company\PurchaseController;
use App\Http\Controllers\Company\InventoryController;
use App\Http\Controllers\Company\SearchItemController;
use App\Http\Controllers\Management\EmployeeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes();

Route::get('/', [welcome::class, 'welcome'])->name('welcome');

Route::get('/remove-ocv-flag', [RemoveOCVFlag::class, 'removeOCVFlag'])->name('removeOCVFlag');

Route::post('/logincanvas', [logincanvas::class, 'logincanvas'])->name('logincanvas');

// Route::get('/c/{cp_index}', [CompanyDashboard::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('index', [DashboardController::class, 'index'])->name('index');
    Route::get('search-item', [SearchItemController::class, 'search'])->name('searchItem');
    Route::get('search-product', [SearchItemController::class, 'searchProduct'])->name('searchProduct');
    Route::resource('user-index', DashboardController::class);
    Route::resource('accounts-index', AccountController::class);
    Route::resource('cashins-index', CashinController::class);
    Route::resource('payments-index', PaymentController::class);
    Route::resource('categories-index', CategoryController::class);
    Route::resource('products-index', ProductController::class);
    Route::resource('inventory-index', InventoryController::class);
    Route::resource('purchase-index', PurchaseController::class);
    Route::resource('sale-index', SaleController::class);
    Route::prefix('/manage/account/{cp_index}')->group(function ($cp_index) {
        Route::get('/{ac_index}', function ($ac_index) {
            return view('company.account', ['ac_index' => $ac_index]);
        });
    });
    Route::prefix('/manage/{cp_index}')->group(function ($cp_index){
        Route::get('/', [CompanyDashboard::class, 'companyDashboard', $cp_index])->name('companyDashboard');
        Route::get('/accounts', [AccountController::class, 'accountIndex', $cp_index])->name('accountIndex');
        Route::get('/accounts/{ac_index}', [AccountController::class, 'accountOV'])->name('account');
        Route::get('/accounts/{ac_index}/cash-in/{ci_index}', [CashinController::class, 'cashinOV'])->name('cashin');
        Route::get('/accounts/{ac_index}/payment/{pm_index}', [PaymentController::class, 'paymentOV'])->name('payment');
        Route::get('/cash-in/create', [CashinController::class, 'cashinIndex'])->name('cashinIndex');
        Route::get('/payment/create', [PaymentController::class, 'paymentIndex'])->name('paymentIndex');
        Route::get('/categories', [CategoryController::class, 'categoryIndex', $cp_index])->name('categoryIndex');
        Route::get('/categories/{ct_index}', [CategoryController::class, 'categoryOV'])->name('category');
        Route::get('/products', [ProductController::class, 'productIndex', $cp_index])->name('productIndex');
        Route::get('/products/{pd_index}', [ProductController::class, 'productOV'])->name('product');
        Route::get('/inventory', [InventoryController::class, 'inventoryIndex', $cp_index])->name('inventoryIndex');
        Route::get('/inventory/{ig_index}', [InventoryController::class, 'itemOV'])->name('inventory');
        Route::get('/purchase', [PurchaseController::class, 'purchaseIndex', $cp_index])->name('purchaseIndex');
        Route::get('/purchase/{pc_index}', [PurchaseController::class, 'purchaseOV'])->name('purchase');
        Route::get('/sale', [SaleController::class, 'saleIndex', $cp_index])->name('saleIndex');
        Route::get('/sale/{sl_index}', [SaleController::class, 'saleOV'])->name('sale');
    });
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
});

/**
 * Route accessible by both 'staff' and 'manager' role
 */
// Route::middleware(['auth', 'role:staff,manager'])->group(function () {
//     Route::get('profile', [ProfileController::class, 'index'])->name('profile');
// });

/**
 * Route accessible by 'staff' role only
 */
// Route::middleware(['auth', 'role:staff'])->group(function () {
//     Route::get('dashboard', [StaffDashboard::class, 'dashboard'])->name('staff.dashboard');
// });

/**
 * Route accessible by 'manager' role only
 */
// Route::prefix('management')->middleware(['auth', 'role:manager'])->group(function() {
//     Route::get('/', [ManagementDashboard::class, 'index'])->name('management.dashboard');
//     Route::resource('employee', EmployeeController::class);
// });

