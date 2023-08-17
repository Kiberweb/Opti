<?php

use App\Http\Controllers\Dashboard\FeedBackListController;
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

Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'dashboard'], function() {
    Route::get('/dashboard', function() {
        Redirect::route('feedback-list.index');
    })->name('dashboard');

    Route::get('/feedback-list', [FeedBackListController::class, 'index'])->name('feedback-list.index');
    Route::put('/feedback-list/{feedback}', [FeedBackListController::class, 'update'])->name('feedback-list.update');
    Route::delete('/feedback-list/{feedback}', [FeedBackListController::class, 'destroy'])->name('feedback-list.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
