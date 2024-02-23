<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UpdateController;
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
    Route::controller(UpdateController::class)
        ->middleware('auth')
        ->group(static function (): void {
            Route::get('/users', 'index')->name('user');
            Route::get('http-pool', 'httpPool');
            Route::get('where-integer-in-row', 'useWhereIntegerInRaw');
            Route::get('chunkbyid', 'useChunkById');
        });
});

require __DIR__.'/auth.php';
