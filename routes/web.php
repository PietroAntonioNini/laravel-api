<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TechnologyController;
use App\Http\Controllers\TypeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Http;

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

//rotta per il refresh-token di google cloud
Route::get('/oauth2callback', [GoogleController::class, 'handleGoogleDriveCallback']);

//proxy per passare le img da google drive al front-end
Route::get('/proxy-image/{fileId}', function($fileId) {
    $url = "https://drive.google.com/uc?export=view&id={$fileId}";
    $response = Http::get($url);

    return response($response->body(), 200)
        ->header('Content-Type', $response->header('Content-Type'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified'])
        ->name('admin.')
        ->prefix('admin')
        ->group(function() {      
            Route::get('/', [DashboardController::class, 'index'])->name('index');

            Route::resource('projects', ProjectController::class)->parameters(['projects' => 'project:slug']);

            Route::resource('technologies', TechnologyController::class);

            Route::resource('types', TypeController::class);

        }
);
