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

        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        $indexJour = date('N') - 1;

        // Vérifier si l'index existe dans le tableau
        $aujourdhuiJour = isset($jours[$indexJour]) ? $jours[$indexJour] : '';

        echo $aujourdhuiJour;


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
