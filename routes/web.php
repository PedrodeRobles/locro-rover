<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\PageController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::redirect('/', 'login');
Route::redirect('/', 'register');

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/', [PageController::class, 'home'])->name('list');
Route::get('/my-list', [PageController::class, 'myList'])->name('my-list');

Route::get('/client/create', [ClientController::class, 'create'])->name('client.create');
Route::post('/client/create', [ClientController::class, 'store'])->name('client.store');
Route::get('/client/edit/{client}', [ClientController::class, 'edit'])->name('client.edit');
Route::put('/client/edit/{client}', [ClientController::class, 'update'])->name('client.update');
Route::get('/client/import', [ClientController::class, 'importView'])->name('client.import_view');
Route::post('/client/import-clients', [ClientController::class, 'importExcel'])->name('client.import');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
