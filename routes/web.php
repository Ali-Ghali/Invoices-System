<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\InvoiceArchiveController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Invoices_Report;
use App\Http\Controllers\Customers_Report;
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
//هذا الروت سيأخذنا مباشرة الى صفحة تسجيل الدخول عند الدخول في صفحة البداية
Route::get('/', function () {
    return view('auth.login');
});

//Route::get('/{page}', 'AdminController@index');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//هذا الروت يأخذنا الى الكنترولر الخاص بالفاتورة
Route::resource('/invoices' , InvoicesController::class);

//هذا الروت يأخذنا الى الكنترولر الخاص بالأقسام
Route::resource('/sections' , SectionsController::class);

//هذا الروت يأخذنا الى الكنترولر الخاص بالمنتجات
Route::resource('/products' , ProductsController::class);

Route::resource('/InvoiceAttachments', InvoiceAttachmentsController::class);

Route::get('/section/{id}', [App\Http\Controllers\InvoicesController::class, 'getproducts'])->name('section');

Route::get('/InvoicesDetails/{id}', [App\Http\Controllers\InvoicesDetailsController::class, 'edit'])->name('InvoicesDetails');

//سيجلب معه رقم الفاتورة واسم الملف لانه نحنا ضمن المجلد ببلك قمنا بحفظ المرفق في مجلد باسم الفاتور
Route::get('View_file/{invoice_number}/{file_name}', [App\Http\Controllers\InvoicesDetailsController::class, 'open_file'])->name('View_file');

//سيجلب معه رقم الفاتورة واسم الملف لانه نحنا ضمن المجلد ببلك قمنا بحفظ المرفق في مجلد باسم الفاتور
Route::get('download/{invoice_number}/{file_name}', [App\Http\Controllers\InvoicesDetailsController::class, 'get_file'])->name('download');

//هذا الروت من أجل الحذف 
Route::post('delete_file', [App\Http\Controllers\InvoicesDetailsController::class, 'destroy'])->name('delete_file');

Route::get('/edit_invoice/{id}', [App\Http\Controllers\InvoicesController::class, 'edit'])->name('edit_invoice');

Route::get('/Status_show/{id}', [App\Http\Controllers\InvoicesController::class, 'show'])->name('Status_show');

Route::post('/Status_Update/{id}', [App\Http\Controllers\InvoicesController::class, 'Status_Update'])->name('Status_Update');

Route::get('Invoice_Paid', [App\Http\Controllers\InvoicesController::class, 'Invoice_Paid'])->name('Invoice_Paid');

Route::get('Invoice_UnPaid', [App\Http\Controllers\InvoicesController::class, 'Invoice_UnPaid'])->name('Invoice_UnPaid');

Route::get('Invoice_Partial', [App\Http\Controllers\InvoicesController::class, 'Invoice_Partial'])->name('Invoice_Partial');

Route::resource('/Archive', InvoiceArchiveController::class);

Route::get('/Print_invoice/{id}', [App\Http\Controllers\InvoicesController::class, 'Print_invoice'])->name('Print_invoice');

Route::get('export_invoices', [App\Http\Controllers\InvoicesController::class, 'export'])->name('export_invoices');

Route::post('import_invoices', [App\Http\Controllers\InvoicesController::class, 'import'])->name('import_invoices');

Route::group(['middleware' => ['auth']], function() {

    Route::resource('/roles' , RoleController::class);
    Route::resource('/users' , UserController::class);
    
    });

Route::get('invoices_report', [App\Http\Controllers\Invoices_Report::class, 'index'])->name('invoices_report');

Route::post('Search_invoices', [App\Http\Controllers\Invoices_Report::class, 'Search_invoices'])->name('Search_invoices');

Route::get('customers_report', [App\Http\Controllers\Customers_Report::class, 'index'])->name('customers_report');

Route::post('Search_customers', [App\Http\Controllers\Customers_Report::class, 'Search_customers'])->name('Search_customers');

Route::get('MarkAsRead_all', [App\Http\Controllers\InvoicesController::class, 'MarkAsRead_all'])->name('MarkAsRead_all');

Route::get('/{page}', [App\Http\Controllers\AdminController::class, 'index'])->name('{page}'); //دائما يجب أن تبقى في الأخير



