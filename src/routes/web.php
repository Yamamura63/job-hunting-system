<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SelfPrController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\SelectionController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/test-session', function () {
    session(['test' => 'hello']);

    return [
        'id' => session()->getId(),
        'value' => session('test'),
    ];
})->middleware('web');

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])

    ->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__ . '/auth.php';

Route::resource('self-prs', SelfPrController::class);
Route::get('/selfPr', [SelfPrController::class, 'index'])
    ->name('selfPr');
Route::get('/selfPr/create', [SelfPrController::class, 'create'])
    ->name('selfPr.create');
Route::get('/selfPr/{selfPr}/edit', [SelfPrController::class, 'edit'])
    ->name('selfPr.edit');


Route::resource('companies', CompanyController::class);
Route::get('/companies', [CompanyController::class, 'index'])
    ->name('company');
Route::get('/companies/create', [CompanyController::class, 'create'])
    ->name('company.create');
Route::post('/companies', [CompanyController::class, 'store'])
    ->name('company.store');

Route::get('/companies/{company}/edit', [CompanyController::class, 'edit'])
    ->name('company.edit');
Route::put('/companies/{company}', [CompanyController::class, 'update'])
    ->name('company.update');
Route::delete('/companies/{company}', [CompanyController::class, 'destroy'])
    ->name('company.destroy');


Route::resource('internships', InternshipController::class);
Route::get('/internships', [InternshipController::class, 'index'])
    ->name('internship');
Route::get('/internships/create', [InternshipController::class, 'create'])
    ->name('internship.create');
Route::post('/internships', [InternshipController::class, 'store'])
    ->name('internship.store');

Route::get('/internships/{internship}/edit', [InternshipController::class, 'edit'])
    ->name('internship.edit');
Route::put('/internships/{internship}', [InternshipController::class, 'update'])
    ->name('internship.update');
Route::delete('/internships/{internship}', [InternshipController::class, 'destroy'])
    ->name('internship.destroy');


Route::resource('selections', SelectionController::class);
Route::get('/selections', [SelectionController::class, 'index'])
    ->name('selection');
Route::get('/selections/create', [SelectionController::class, 'create'])
    ->name('selection.create');
Route::post('/selections', [SelectionController::class, 'store'])
    ->name('selection.store');

Route::get('/selections/{selection}/edit', [SelectionController::class, 'edit'])
    ->name('selection.edit');
Route::put('/selections/{selection}', [SelectionController::class, 'update'])
    ->name('selection.update');
Route::delete('/selections/{selection}', [SelectionController::class, 'destroy'])
    ->name('selection.destroy');
