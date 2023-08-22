<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;

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

Route::get('/',[HomeController::class,'index']);

Route::get('/redirect',[HomeController::class,'redirect'])->middleware('auth','verified');

Route::get('/product_details/{id}',[HomeController::class,'product_details']);

Route::get('/show_cart',[HomeController::class,'show_cart']);

Route::get('/show_order',[HomeController::class,'show_order']);

Route::get('/remove_cart/{id}',[HomeController::class,'remove_cart']);

Route::get('/cancel_order/{id}',[HomeController::class,'cancel_order']);

Route::get('/cash_order',[HomeController::class,'cash_order']);

Route::get('/show_products',[HomeController::class,'show_products']);

Route::get('/contact',[HomeController::class,'contact']);

Route::get('/blog',[HomeController::class,'blog']);

Route::get('/pay/{totalprice}',[PaymentController::class,'pay']);

Route::get('/search_products_user',[HomeController::class,'search_products_user']);

Route::post('/add_cart/{id}',[HomeController::class,'add_cart']);

Route::post('/add_comment',[HomeController::class,'add_comment']);

Route::post('/contact_us',[HomeController::class,'contact_us']);

Route::post('/add_reply',[HomeController::class,'add_reply']);

Route::get('success',[PaymentController::class,'success']);

Route::get('error',[PaymentController::class,'error']);



Route::group(['middleware'=>['auth','admin']],function(){

Route::get('/view_catagory',[AdminController::class,'view_catagory']);

Route::get('/delete_catagory/{id}',[AdminController::class,'delete_catagory']);

Route::get('/view_product',[AdminController::class,'view_product']);

Route::get('/show_product',[AdminController::class,'show_product']);

Route::get('/delete_product/{id}',[AdminController::class,'delete_product']);

Route::get('/edit_product/{id}',[AdminController::class,'edit_product']);

Route::get('/delivered/{id}',[AdminController::class,'delivered']);

Route::get('/print_pdf/{id}',[AdminController::class,'print_pdf']);

Route::get('/send_email/{id}',[AdminController::class,'send_email']);

Route::get('/reply_email/{id}',[AdminController::class,'reply_email']);

Route::get('/order',[AdminController::class,'order']);

Route::get('/queries',[AdminController::class,'queries']);

Route::get('/search',[AdminController::class,'search']);

Route::get('/search_products',[AdminController::class,'search_products']);

Route::post('/update_product/{id}',[AdminController::class,'update_product']);

Route::post('/reply_user_email/{id}',[AdminController::class,'reply_user_email']);

Route::post('/add_product',[AdminController::class,'add_product']);

Route::post('/add_catagory',[AdminController::class,'add_catagory']);



});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
