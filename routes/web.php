<?php

use App\Classes\Firewall;
use App\Classes\ReportAnalyzer;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UpdateController;
use App\Jobs\SendWelcomeEmail;
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

Route::get('/test-bindings', function () {
    dd(app(Firewall::class));
    // dd(app(ReportAnalyzer::class));
    // $photoController = app(PhotoController::class);
    // dd($photoController->capture());
    $bindService1 = app('App\Services\BindService');
    $bindService2 = app('App\Services\BindService');

    $singletonService1 = app('App\Services\SingletonService');
    $singletonService2 = app('App\Services\SingletonService');

    $scopedService1 = app('App\Services\ScopedService');
    $scopedService2 = app('App\Services\ScopedService');

    $instanceService1 = app('App\Services\InstanceService');
    $instanceService2 = app('App\Services\InstanceService');

    return response()->json([
        'bind' => [$bindService1->getId(), $bindService2->getId()],
        'singleton' => [$singletonService1->getId(), $singletonService2->getId()],
        'scoped' => [$scopedService1->getId(), $scopedService2->getId()],
        'instance' => [$instanceService1->getId(), $instanceService2->getId()],
    ]);
});

Route::get('job', function () {
    SendWelcomeEmail::dispatch();

    return 'success';
});

require __DIR__.'/auth.php';
