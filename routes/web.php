<?php

use App\Http\Controllers\CampsiteController;
use App\Http\Controllers\CampsiteSpotController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('/campsites')->group(function () {
        Route::get('/', [CampsiteController::class, 'index'])->name('campsites.index');
        Route::get('/new', [CampsiteController::class, 'new'])->name('campsites.new');
        Route::get('/{campsite}', [CampsiteController::class, 'show'])->where("campsite", "[0-9]+")->name('campsites.edit');
        Route::post('/', [CampsiteController::class, 'store'])->name('campsites.create');
        Route::put('/{campsite}', [CampsiteController::class, 'store'])->where("campsite", "[0-9]+")->name('campsites.store');
        Route::delete('/{campsite}', [CampsiteController::class, 'destroy'])->where("campsite", "[0-9]+")->name('campsites.destroy');

        Route::get('/{campsite}/images/{campsite_image}', [CampsiteController::class, 'show_campsite_image'])->where("campsite", "[0-9]+")->name('campsites.image');
    });


    Route::prefix('/campsite_spots')->group(function () {
        Route::get('/', [CampsiteSpotController::class, 'index'])->name('campsite_spots.index');
        Route::get('/new', [CampsiteSpotController::class, 'new'])->name('campsite_spots.new');
        Route::get('/{campsite_spot}', [CampsiteSpotController::class, 'show'])->where("campsite_spot", "[0-9]+")->name('campsite_spots.edit');
        Route::post('/', [CampsiteSpotController::class, 'store'])->name('campsite_spots.create');
        Route::put('/{campsite_spot}', [CampsiteSpotController::class, 'store'])->where("campsite_spot", "[0-9]+")->name('campsite_spots.store');
        Route::delete('/{campsite_spot}', [CampsiteSpotController::class, 'destroy'])->where("campsite_spot", "[0-9]+")->name('campsite_spots.destroy');
    });
});

require __DIR__ . '/auth.php';
