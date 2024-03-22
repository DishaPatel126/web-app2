<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

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

Route::webhooks('webhooks');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

Route::resource('dashboard', ProductController::class);

// Route::get('/dashboard', function(){
//     return view('products.productsTable');
// });

// Route::middleware('auth')->group(function(){
//     Route::resource('products', ProductController::class);
// });


Route::post('/create/webhook-url',[WebhookController::class,'getWebhook']);

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });