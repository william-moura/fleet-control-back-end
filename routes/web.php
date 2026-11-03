<?php

use App\Http\Controllers\CompanyRegistrationController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\PreventAccessFromTenantDomains;
use App\Http\Middleware\UserLoggedIn;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware([
    'web',
    UserLoggedIn::class              // Sua trava de segurança para checar se o usuário é Admin
])
->prefix('admin')
->group(function () {
    Route::get('/', [CompanyRegistrationController::class, 'index'])->name('admin.index');
    Route::get('/create', [CompanyRegistrationController::class, 'create'])->name('admin.create');
    Route::post('/store', [CompanyRegistrationController::class, 'register'])->name('admin.store');
    Route::get('/edit/{id}', [CompanyRegistrationController::class, 'edit'])->name('admin.edit');
    Route::post('/update/{id}', [CompanyRegistrationController::class, 'update'])->name('admin.update');
    Route::delete('/destroy/{id}', [CompanyRegistrationController::class, 'destroy'])->name('admin.destroy');
});
Route::get('/admin/login', [LoginController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'authenticate'])->name('admin.login.authenticate');

