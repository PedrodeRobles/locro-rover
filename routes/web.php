<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::redirect('/', 'register');
Route::redirect('/', 'login');
Route::get('/guest', [PageController::class, 'guest'])->name('guest');

Route::middleware(['auth', 'active-user'])->group(function() {
    Route::get('/', [PageController::class, 'home'])->name('list');
    Route::get('/my-list', [PageController::class, 'myList'])->name('my-list');
    Route::put('/order/{order:id}/edit/{field}', [OrderController::class, 'update'])->name('order.update');
    Route::post('/order/{order:id}/addObservation', [OrderController::class, 'addObservation'])->name('order.addObservation');
    Route::delete('/order/{order:id}/{observation:id}/deleteObservation', [OrderController::class, 'deleteObservation'])->name('order.deleteObservation');
    Route::delete('/order/{order:id}/delete', [OrderController::class, 'destroy'])->name('order.destroy');
    Route::post('/order/create', [OrderController::class, 'store'])->name('order.store');
    
    Route::post('/client/create', [ClientController::class, 'store'])->name('client.store');
    Route::put('/client/{order:id}/edit/{field}', [ClientController::class, 'updateFromOrder'])->name('client.updateFromOrder');
    Route::post('/client/{order:id}/add-order', [ClientController::class, 'addOrder'])->name('client.addOrder');

    Route::middleware(['role:Admin,Logistica'])->group(function() {
        Route::get('/clients', [ClientController::class, 'index'])->name('client.index');
        Route::get('/client/create', [ClientController::class, 'create'])->name('client.create');
        Route::get('/client/edit/{client:id}', [ClientController::class, 'edit'])->name('client.edit');
        Route::put('/client/edit/{client}', [ClientController::class, 'update'])->name('client.update');
        Route::delete('/client/delete/{client:id}', [ClientController::class, 'destroy'])->name('client.destroy');
        Route::get('/client/import', [ClientController::class, 'importView'])->name('client.import_view');
        Route::post('/client/import-clients', [ClientController::class, 'importExcel'])->name('client.import');
        Route::get('/client/clientHasOrder/{client:id}', [ClientController::class, 'clientHasOrder'])->name('client.clientHasOrder');
        Route::get('/client/deleteClients', [ClientController::class, 'deleteClients'])->name('client.deleteClients');
        Route::put('/client/rollback/{client}', [ClientController::class, 'rollbackClient'])->name('client.rollbackClient');

        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/years', [AdminController::class, 'years'])->name('admin.years');
        Route::post('/year/store', [AdminController::class, 'createThisYear'])->name('admin.year.store');
        Route::get('/parameters/{edit?}', [AdminController::class, 'parameters'])->name('admin.parameters');
        Route::post('/parameters/store', [AdminController::class, 'storeParameters'])->name('admin.parameters.store');
        Route::put('/parameters/edit/{parameter}', [AdminController::class, 'updateParameters'])->name('admin.parameters.update');
        Route::get('/admin/export-orders', [AdminController::class, 'exportOrders'])->name('admin.export-orders');
        Route::get('/admin/roles', [AdminController::class, 'roles'])->name('admin.roles');
        Route::put('/admin/assign_roles/{user_id}/{role_name}', [AdminController::class, 'assignRoles'])->name('admin.assign.roles');
        Route::put('/admin/users/{user_id}/softDelete', [AdminController::class, 'softDelete'])->name('admin.users.soft-delete');
        Route::get('/admin/users/softDeleted', [AdminController::class, 'softDeletedUsers'])->name('admin.users.soft-deleted');
        Route::put('/admin/users/{user_id}/rollbackUser', [AdminController::class, 'rollbackUser'])->name('admin.users.rollback-user');
    });
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
