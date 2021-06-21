<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UsersController;
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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/register', [UsersController::class, 'register']);
Route::get('/login', [UsersController::class, 'login'])->name('login');

Route::post('/auth', [UsersController::class, 'authenticate']);
Route::get('/logout', [UsersController::class, 'logout']);

Route::get('/products', [ProductsController::class, 'show'])->middleware('auth');

Route::get('/products/page/{page}', [ProductsController::class, 'indexPerPage'])->middleware('auth');
Route::post('/products/page', [ProductsController::class, 'showPerPage'])->middleware('auth');
Route::post('/products/photos', [ProductsController::class, 'getProductPhotos'])->middleware('auth');

Route::get('/dashboard', [ProductsController::class, 'index'])->middleware('auth');
Route::get('/dashboard/products/add', [ProductsController::class, 'create'])->middleware('auth');
Route::get('dashboard/products/update/{productId}', [ProductsController::class, 'edit'])->middleware('auth');


Route::get('/products/{id}', [ProductsController::class, 'get'])->middleware('auth');
Route::post('/products/search', [ProductsController::class, 'search'])->middleware('auth');
Route::post('/products/category/search', [ProductsController::class, 'searchCategory'])->middleware('auth');
Route::post('/products/add', [ProductsController::class, 'add'])->middleware('auth');
Route::post('/products/update', [ProductsController::class, 'update'])->middleware('auth');
Route::post('/products/delete', [ProductsController::class, 'delete'])->middleware('auth');

