<?php

use App\Http\Controllers\CompanyRegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin', [CompanyRegistrationController::class, 'index'])->name('admin.index');

Route::get('/admin/create', [CompanyRegistrationController::class, 'create'])->name('admin.create');
Route::post('/admin/store', [CompanyRegistrationController::class, 'register'])->name('admin.store');
Route::get('/admin/edit/{id}', [CompanyRegistrationController::class, 'edit'])->name('admin.edit');
Route::post('/admin/update/{id}', [CompanyRegistrationController::class, 'update'])->name('admin.update');
Route::delete('/admin/destroy/{id}', [CompanyRegistrationController::class, 'destroy'])->name('admin.destroy');
