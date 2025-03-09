<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Cours;
use App\Models\Etudiant;
use App\Models\Professeur;
use App\Models\EmploiDuTemps;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques pour le tableau de bord
        $totalClasses = Classe::count();
        $totalCours = Cours::count();
        $totalEtudiants = Etudiant::count();
        $totalProfesseurs = Professeur::count();

        // Cours du jour pour les 5 premières classes
        $aujourdhuiJour = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'][date('N') - 1];

        $emploisDuJour = EmploiDuTemps::where('jour', $aujourdhuiJour)
            ->with(['classe', 'cours', 'professeur'])
            ->orderBy('heure_debut')
            ->take(10)
            ->get();

        // Classes avec le plus d'étudiants
        $classesPopulaires = Classe::withCount('etudiants')
            ->orderBy('etudiants_count', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalClasses',
            'totalCours',
            'totalEtudiants',
            'totalProfesseurs',
            'emploisDuJour',
            'classesPopulaires',
            'aujourdhuiJour'
        ));
    }
}
