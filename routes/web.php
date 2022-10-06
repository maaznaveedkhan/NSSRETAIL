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
    return redirect()->route('home');
})->name('/');
// Route::get('/', function () {
//     return view('frontend.dashboard');
// });
// Route::get('logout',[App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => ['user', 'auth']], function () {
    Route::get('all_business' , [BusinessController::class, 'AllBusinesses'])->name('all_business');
    // Business
    Route::post('new_business' , [BusinessController::class, 'NewBusiness'])->name('new_business');
    Route::get('business_page/{id}' , [BusinessController::class, 'BusinessPage'])->name('business_page');
    // Stock Book
    Route::get('stock_book/{id}',[App\Http\Controllers\StockController::class,'stock_book'])->name('stock_book');
    Route::get('delete_stock/{id}',[App\Http\Controllers\StockController::class,'delete_stock'])->name('delete_stock');
    Route::post('add_item', [StockController::class, 'add_item'])->name('add_item');
    Route::get('stock_page/{id}' , [StockController::class, 'stock_page'])->name('stock_page');
    Route::post('qty_in', [App\Http\Controllers\StockQuantityController::class, 'qty_in'])->name('qty_in');
    Route::post('qty_out', [App\Http\Controllers\StockQuantityController::class, 'qty_out'])->name('qty_out');
    // Bill Book
    Route::get('bill_book/{id}',[App\Http\Controllers\BillController::class,'bill_book'])->name('bill_book');
    Route::get('new_bill/{id}',[App\Http\Controllers\BillController::class,'new_bill'])->name('new_bill');
    Route::post('create_bill',[App\Http\Controllers\BillController::class,'create_bill'])->name('create_bill');
    Route::post('add_items', [App\Http\Controllers\BillDetailController::class, 'bill_detail'])->name('add_items');
    Route::get('edit_bill/{id}' , [App\Http\Controllers\BillBookController::class, 'edit_bill'])->name('edit_bill');
    Route::get('update_bill/{id}' , [App\Http\Controllers\BillBookController::class, 'update_bill'])->name('update_bill');
    Route::get('delete_bill/{id}' , [App\Http\Controllers\BillController::class, 'delete_bill'])->name('delete_bill');
    // Bank Account
    Route::get('bank_accounts/{id}',[App\Http\Controllers\BankAccountController::class,'bank_accounts'])->name('bank_accounts');
    Route::post('add_bank_ac',[App\Http\Controllers\BankAccountController::class,'add_bank_ac'])->name('add_bank_ac');
    // Cash Book
    Route::get('cash_book/{id}',[App\Http\Controllers\CashController::class,'cash_book'])->name('cash_book');
    Route::post('add_entry',[App\Http\Controllers\CashController::class,'add_entry'])->name('add_entry');
    Route::get('all_cash',[App\Http\Controllers\CashController::class,'allCash'])->name('cash');
    Route::post('add_cash',[App\Http\Controllers\CashController::class,'addCash'])->name('new-cash');
    Route::post('cash_in',[App\Http\Controllers\CashController::class,'cash_in'])->name('cash_in');
    Route::post('cash_out',[App\Http\Controllers\CashController::class,'cash_out'])->name('cash_out');
    // Money Receive Book
    Route::get('money_receive_book/{id}',[App\Http\Controllers\MoneyReceiveBookController::class,'money_receive_book'])->name('money_receive_book');
    Route::post('add_party',[App\Http\Controllers\MoneyReceiveBookController::class,'add_party'])->name('add_party');
    Route::post('money_in',[App\Http\Controllers\MoneyReceiveBookController::class,'money_in'])->name('money_in');
    Route::post('money_out',[App\Http\Controllers\MoneyReceiveBookController::class,'money_out'])->name('money_out');
    // Invoice / Order
    Route::get('all_invoices/{id}',[App\Http\Controllers\InvoiceController::class,'all_invoices'])->name('all_invoices');
    Route::post('create_invoice',[App\Http\Controllers\InvoiceController::class,'create_invoice'])->name('create_invoice');
    Route::get('new_invoice/{id}',[App\Http\Controllers\InvoiceController::class,'new_invoice'])->name('new_invoice');
    Route::post('add_invoice_items', [App\Http\Controllers\InvoiceController::class, 'invoice_detail'])->name('add_invoice_items');
    // Customers
    Route::get('all_customers/{id}',[App\Http\Controllers\CustomerController::class, 'all_customers'])->name('all_customers');
    Route::post('add_customer' , [App\Http\Controllers\CustomerController::class, 'AddCustomer'])->name('add_customer');
    Route::get('customer/{id}' , [App\Http\Controllers\CustomerController::class, 'CustomerPage'])->name('customer');
    Route::post('given_amount' , [CustomerController::class, 'GivenAmount'])->name('given_amount');
    Route::post('got_amount' , [CustomerController::class, 'GotAmount'])->name('got_amount');
    Route::put('update_amount' , [CustomerController::class, 'UpdateAmount'])->name('update_amount');
    Route::delete('delete_amount' , [CustomerController::class, 'DeleteAmount'])->name('delete_amount');
    // Suppliers
    Route::get('all_suppliers/{id}', [App\Http\Controllers\SupplierController::class, 'all_suppliers'])->name('all_suppliers');
    Route::post('add_supplier' , [App\Http\Controllers\SupplierController::class, 'AddSupplier'])->name('add_supplier');
    Route::get('supplier/{id}' , [App\Http\Controllers\SupplierController::class, 'SupplierPage'])->name('supplier');
    Route::post('purchase' , [SupplierController::class, 'Purchase'])->name('purchase');
    Route::post('payment' , [SupplierController::class, 'Payment'])->name('payment');
    Route::put('update_payment' , [SupplierController::class, 'UpdatePayment'])->name('update_payment');
    Route::delete('delete_payment' , [SupplierController::class, 'DeletePayment'])->name('delete_payment');
});

// Route::get('login', function () {
//     return view('layout.login');
// });

// Route::post('post_login',[AuthController::class,'user'])->name('post-name');

// Route::get('/tasks', [CustomerController::class,'exportCsv']);

// Route::get('view_report/{id}', [ReportController::class, 'ViewReport'])->name('view_report');
// Route::get('import_file', [CustomerController::class, 'ImportFile'])->name('import_file');
// Route::post('file', [CustomerController::class, 'File'])->name('file');

Route::group(['middleware' => ['admin', 'auth']], function () {
    Route::get('/admin_dashboard', [App\Http\Controllers\HomeController::class, 'admin_dashboard'])->name('admin_dashboard');
});
