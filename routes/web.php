<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillBookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CashBookController;
use App\Http\Controllers\CashController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockController;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::get('home_page', function () {
    return view('layout.home_page');
});

Route::get('login', function () {
    return view('layout.login');
});

Route::post('post_login',[AuthController::class,'user'])->name('post-name');

Route::get('/tasks', [CustomerController::class,'exportCsv']);

Route::post('new_business' , [BusinessController::class, 'NewBusiness'])->name('new_business');
Route::get('business_page/{id}' , [BusinessController::class, 'BusinessPage'])->name('business_page');
Route::post('given_amount' , [CustomerController::class, 'GivenAmount'])->name('given_amount');
Route::post('got_amount' , [CustomerController::class, 'GotAmount'])->name('got_amount');
Route::put('update_amount' , [CustomerController::class, 'UpdateAmount'])->name('update_amount');
Route::delete('delete_amount' , [CustomerController::class, 'DeleteAmount'])->name('delete_amount');


Route::get('all_customers' , [CustomerController::class, 'AllCustomers'])->name('all_customers');
Route::post('add_customer' , [CustomerController::class, 'AddCustomer'])->name('add_customer');
Route::get('customer/{id}' , [CustomerController::class, 'CustomerPage'])->name('customer');

Route::get('all_suppliers/{business_id}', [SupplierController::class, 'AllSuppliers'])->name('all_suppliers');
Route::post('add_supplier' , [SupplierController::class, 'AddSupplier'])->name('add_supplier');
Route::get('supplier/{id}' , [SupplierController::class, 'SupplierPage'])->name('supplier');

Route::get('all_cash',[CashController::class,'allCash'])->name('cash');
Route::post('add_cash',[CashController::class,'addCash'])->name('new-cash');

Route::post('purchase' , [SupplierController::class, 'Purchase'])->name('purchase');
Route::post('payment' , [SupplierController::class, 'Payment'])->name('payment');
Route::put('update_payment' , [SupplierController::class, 'UpdatePayment'])->name('update_payment');
Route::delete('delete_payment' , [SupplierController::class, 'DeletePayment'])->name('delete_payment');

//Stock Route
Route::get('stock/{id}', [StockController::class, 'index'])->name('view_stock');
Route::post('add_item', [StockController::class, 'add_item'])->name('add_item');
Route::get('stock_page/{id}' , [StockController::class, 'stock_page'])->name('stock_page');
Route::post('qty_in', [App\Http\Controllers\StockQuantityController::class, 'qty_in'])->name('qty_in');
Route::post('qty_out', [App\Http\Controllers\StockQuantityController::class, 'qty_out'])->name('qty_out');


Route::get('view_report/{id}', [ReportController::class, 'ViewReport'])->name('view_report');
Route::get('import_file', [CustomerController::class, 'ImportFile'])->name('import_file');
Route::post('file', [CustomerController::class, 'File'])->name('file');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();
Route::group(['middleware' => ['user', 'auth']], function () {
    Route::get('all_business' , [BusinessController::class, 'AllBusinesses'])->name('all_business');
    Route::get('cash' , [CashBookController::class, 'cash'])->name('cash');
    Route::post('create_bill',[App\Http\Controllers\BillBookController::class,'add_bill'])->name('create_bill');
    Route::get('edit_bill/{id}' , [App\Http\Controllers\BillBookController::class, 'edit_bill'])->name('edit_bill');
    Route::get('update_bill/{id}' , [App\Http\Controllers\BillBookController::class, 'update_bill'])->name('update_bill');
    Route::get('delete_bill/{id}' , [App\Http\Controllers\BillBookController::class, 'delete_bill'])->name('delete_bill');
    Route::post('cash_in',[App\Http\Controllers\CashBookController::class,'cash_in'])->name('cash_in');
    Route::post('cash_out',[App\Http\Controllers\CashBookController::class,'cash_out'])->name('cash_out');
    Route::post('add_bank_ac',[App\Http\Controllers\BankAccountController::class,'add_bank_ac'])->name('add_bank_ac');
    // Route::get('/user_dashboard', [App\Http\Controllers\HomeController::class, 'user_dashboard'])->name('user_dashboard');
});
Route::group(['middleware' => ['admin', 'auth']], function () {
    Route::get('/admin_dashboard', [App\Http\Controllers\HomeController::class, 'admin_dashboard'])->name('admin_dashboard');
});