<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SelfPrController;
use Illuminate\Support\Facades\Route;

Route::get('/test-session', function () {
    session(['test' => 'hello']);

    return [
        'id' => session()->getId(),
        'value' => session('test'),
    ];
})->middleware('web');

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

require __DIR__.'/auth.php';

Route::resource('self-prs', SelfPrController::class);
Route::get('/selfPr', [SelfPrController::class, 'index'])
    ->name('selfPr');
Route::get('/selfPr/create', [SelfPrController::class, 'create'])
    ->name('selfPr.create');
Route::post('/selfPr', [SelfPrController::class, 'store'])
    ->name('selfPr.store');

Route::get('/selfPr/{selfPr}/edit', [SelfPrController::class, 'edit'])
    ->name('selfPr.edit');
Route::put('/selfPr/{selfPr}', [SelfPrController::class, 'update'])
    ->name('selfPr.update');
Route::delete('/selfPr/{selfPr}', [SelfPrController::class, 'destroy'])
    ->name('selfPr.destroy');
