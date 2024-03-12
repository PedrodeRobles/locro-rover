<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrderController;
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
Route::put('/order/{order:id}/edit/{field}', [OrderController::class, 'update'])->name('order.update');
Route::post('/order/{order:id}/addObservation', [OrderController::class, 'addObservation'])->name('order.addObservation');
Route::delete('/order/{order:id}/{observation:id}/deleteObservation', [OrderController::class, 'deleteObservation'])->name('order.deleteObservation');
Route::delete('/order/{order:id}/delete', [OrderController::class, 'destroy'])->name('order.destroy');
Route::post('/order/create', [OrderController::class, 'store'])->name('order.store');

Route::get('/clients', [ClientController::class, 'index'])->name('client.index');
Route::get('/client/create', [ClientController::class, 'create'])->name('client.create');
Route::post('/client/create', [ClientController::class, 'store'])->name('client.store');
Route::get('/client/edit/{client:id}', [ClientController::class, 'edit'])->name('client.edit');
Route::put('/client/edit/{client}', [ClientController::class, 'update'])->name('client.update');
Route::delete('/client/delete/{client:id}', [ClientController::class, 'destroy'])->name('client.destroy');
Route::get('/client/import', [ClientController::class, 'importView'])->name('client.import_view');
Route::post('/client/import-clients', [ClientController::class, 'importExcel'])->name('client.import');
Route::get('/client/clientHasOrder/{client:id}', [ClientController::class, 'clientHasOrder'])->name('client.clientHasOrder');
Route::get('/client/deleteClients', [ClientController::class, 'deleteClients'])->name('client.deleteClients');
Route::put('/client/rollback/{client}', [ClientController::class, 'rollbackClient'])->name('client.rollbackClient');
Route::put('/client/{order:id}/edit/{field}', [ClientController::class, 'updateFromOrder'])->name('client.updateFromOrder');
Route::post('/client/{order:id}/add-order', [ClientController::class, 'addOrder'])->name('client.addOrder');


Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('/years', [AdminController::class, 'years'])->name('admin.years');
Route::post('/year/store', [AdminController::class, 'createThisYear'])->name('admin.year.store');
Route::get('/parameters/{edit?}', [AdminController::class, 'parameters'])->name('admin.parameters');
Route::post('/parameters/store', [AdminController::class, 'storeParameters'])->name('admin.parameters.store');
Route::put('/parameters/edit/{parameter}', [AdminController::class, 'updateParameters'])->name('admin.parameters.update');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
