<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StripeController;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::get('/',[HomeController::class,'index'])->name('index');
Route::get('/redirect',[HomeController::class,'redirect'])->middleware('auth','verified')->name('redirect');

Route::get('/view_category',[AdminController::class,'view_category'])->name('view_category')->middleware('admin');
Route::post('/add_category',[AdminController::class,'add_category'])->middleware(['auth','admin'])->name('add_category');
Route::get('/delete_category/{id}',[AdminController::class,'delete_category'])->middleware(['auth','admin'])->name('delete_category');

Route::get('/view_products',[AdminController::class, 'view_products'])->middleware(['auth','admin'])->name('view_products');
Route::post('/show_products',[AdminController::class, 'add_products'])->middleware(['auth','admin'])->name('add_products');
Route::get('/show_products',[AdminController::class, 'show_products'])->middleware(['auth','admin'])->name('show_products');
Route::get('/delete_products/{id}',[AdminController::class, 'delete_products'])->middleware(['auth','admin'])->name('delete_products');
Route::get('/edit_products/{id}',[AdminController::class, 'edit_products'])->middleware(['auth','admin'])->name('edit_products');
Route::patch('/update_products/{id}',[AdminController::class, 'update_products'])->middleware(['auth','admin'])->name('update_products');
Route::get('/order_details',[AdminController::class, 'order_details'])->middleware(['auth','admin'])->name('order_details');
Route::get('/delevered/{id}',[AdminController::class, 'delevered'])->middleware(['auth','admin'])->name('delevered');
Route::get('/print_pdf/{id}',[AdminController::class, 'print_pdf'])->middleware(['auth','admin'])->name('print_pdf');
Route::get('/send_email/{id}',[AdminController::class, 'send_email'])->middleware(['auth','admin'])->name('send_email');
Route::post('/send_user_email/{id}',[AdminController::class, 'send_user_email'])->middleware(['auth','admin'])->name('send_user_email');
Route::get('/search',[AdminController::class, 'search'])->middleware(['auth','admin'])->name('search');


Route::get('/product_details/{id}',[HomeController::class,'product_details'])->name('product_details');
Route::post('/add_cart/{id}',[HomeController::class,'add_cart'])->name('add_cart');
Route::get('/cart_show',[HomeController::class,'cart_show'])->name('cart_show');
Route::get('/remove_cart/{id}',[HomeController::class,'remove_cart'])->name('remove_cart');
Route::get('/cash_order',[HomeController::class,'cash_order'])->name('cash_order');
Route::get('/stripe/{total}',[HomeController::class,'stripe'])->name('stripe');
Route::post('stripe/{total}', [HomeController::class,'stripePost'])->name('stripe.post');
Route::get('order_view', [HomeController::class,'order_view'])->name('order_view');
Route::get('cancel_order/{id}', [HomeController::class,'cancel_order'])->name('cancel_order');

Route::post('add_comment', [HomeController::class,'add_comment'])->name('add_comment');
Route::post('add_reply', [HomeController::class,'add_reply'])->name('add_reply');
Route::get('search_product', [HomeController::class,'search_product'])->name('search_product');
Route::get('all_products', [HomeController::class,'all_products'])->name('all_products');
Route::get('contact', [HomeController::class,'contact'])->name('contact');
Route::get('product_search', [HomeController::class,'product_search'])->name('product_search');
