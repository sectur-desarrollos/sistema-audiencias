<?php

use App\Http\Controllers\AudienceController;
use App\Http\Controllers\AudienceStatusController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactTypeController;
use App\Http\Controllers\DependencyController;


Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AuthController::class, 'showDashboard'])->name('dashboard');
    
    // Autenticación
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Audiencias
    Route::resource('audiences', AudienceController::class)->names('audiences');
    Route::get('/audiences/{audience}/pdf', [AudienceController::class, 'generatePDF'])->name('audiences.pdf');
    Route::get('/audiences/{audience}/pdf-companies', [AudienceController::class, 'generateCompaniesPDF'])->name('audiences.pdf-companies');

    // Tipo de contactos
    Route::resource('contact-types', ContactTypeController::class)->names('contact-types');

    // Dependencias
    Route::resource('dependencies', DependencyController::class)->names('dependencies');

    // Catalogo de estados de la audiencia
    Route::resource('audience-statuses', AudienceStatusController::class)->names('audience-statuses');


});