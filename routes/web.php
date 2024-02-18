<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UpdatesController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group([
    'prefix' => 'v1',
], static function (): void {
    Route::controller(UpdatesController::class)
        ->middleware('auth')
        ->group(static function (): void {
            Route::get('http-pool', 'httpPool');
            Route::get('where-integer-in-row', 'useWhereIntegerInRaw')->name('user');
        });
});

require __DIR__.'/auth.php';
