<?php

use App\Http\Controllers\FeedBackController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

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
    return Redirect::route('feedback.index');
})->name('main');

Route::get('/feedback', [FeedBackController::class, 'index'])->name('feedback.index');
Route::post('/feedback', [FeedBackController::class, 'store'])->name('feedback.store');
//Route::put('/feedback/{feedBack}', [FeedBackController::class, 'update'])->name('feedback.update');
//Route::delete('/feedback/{feedBack}', [FeedBackController::class, 'destroy'])->name('feedback.destroy');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
