<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProductController;

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
Route::get('/home', function () {
    return redirect('/admin/home');
});

Auth::routes();

Route::get('/admin/home', [HomeController::class, 'index'])->name('home');

Route::resource('admin/shop', ShopController::class);

Route::get('admin/export-shop', [ShopController::class, 'export']);
Route::post('admin/import-shop', [ShopController::class, 'import']);

Route::post('/admin/shop/show-all', [ShopController::class, 'requestDatatable']);

Route::resource('admin/product', ProductController::class);

Route::post('/admin/product/show-all', [ProductController::class, 'requestDatatable']);
