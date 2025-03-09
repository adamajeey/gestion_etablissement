<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\classeController;
use App\Http\Controllers\CoursController;
use App\Http\Controllers\ProfesseurController;
use App\Http\Controllers\EmploiDuTempsController;
use App\Http\Controllers\EtudiantController;


// Page d'accueil (redirection vers le tableau de bord)
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Tableau de bord
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Routes pour la gestion des classes
Route::resource('classes', ClasseController::class)->parameters([
    'classes' => 'classe'
]);

// Routes pour la gestion des cours
Route::resource('cours', CoursController::class)->parameters([
    'cours' => 'cours'
]);

// Routes pour la gestion des professeurs
Route::resource('professeurs', ProfesseurController::class)->parameters([
    'professeurs' => 'professeur'
]);

// Routes pour la gestion des étudiants
Route::resource('etudiants', EtudiantController::class)->parameters([
    'etudiants' => 'etudiant'
]);

// Routes pour la gestion des emplois du temps
Route::resource('emploi-du-temps', EmploiDuTempsController::class)->parameters([
    'emploi-du-temps' => 'emploiDuTemps'
]);
