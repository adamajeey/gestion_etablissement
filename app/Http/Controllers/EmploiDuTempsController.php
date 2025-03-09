<?php

namespace App\Http\Controllers;

use App\Models\EmploiDuTemps;
use App\Models\Classe;
use App\Models\Cours;
use App\Models\Professeur;
use Illuminate\Http\Request;

class EmploiDuTempsController extends Controller
{
    public function index(Request $request)
    {
        $classes = Classe::orderBy('niveau', 'asc')
            ->orderBy('nom', 'asc')
            ->get();

        $classeId = $request->query('classe_id');

        if ($classeId) {
            $classe = Classe::findOrFail($classeId);
            $emploisDuTemps = EmploiDuTemps::where('classe_id', $classeId)
                ->with(['cours', 'professeur'])
                ->orderBy('jour')
                ->orderBy('heure_debut')
                ->get();

            $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
            $emploiParJour = [];

            foreach ($jours as $jour) {
                $emploiParJour[$jour] = $emploisDuTemps->filter(function($item) use ($jour) {
                    return $item->jour === $jour;
                })->sortBy('heure_debut');
            }

            return view('emploi_du_temps.index', compact('classes', 'classe', 'emploiParJour', 'jours'));
        }

        return view('emploi_du_temps.index', compact('classes'));
    }

    public function create()
    {
        $classes = Classe::orderBy('niveau', 'asc')
            ->orderBy('nom', 'asc')
            ->get();
        $cours = Cours::orderBy('nom', 'asc')->get();
        $professeurs = Professeur::orderBy('nom', 'asc')
            ->orderBy('prenom', 'asc')
            ->get();
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];

        return view('emploi_du_temps.create', compact('classes', 'cours', 'professeurs', 'jours'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'cours_id' => 'required|exists:cours,id',
            'professeur_id' => 'required|exists:professeurs,id',
            'jour' => 'required|in:Lundi,Mardi,Mercredi,Jeudi,Vendredi,Samedi',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'salle' => 'required|string|max:255',
        ]);

        // Vérifier les conflits d'horaire pour la classe
        $conflitsClasse = EmploiDuTemps::where('classe_id', $validated['classe_id'])
            ->where('jour', $validated['jour'])
            ->where(function($query) use ($validated) {
                $query->whereBetween('heure_debut', [$validated['heure_debut'], $validated['heure_fin']])
                    ->orWhereBetween('heure_fin', [$validated['heure_debut'], $validated['heure_fin']])
                    ->orWhere(function($q) use ($validated) {
                        $q->where('heure_debut', '<=', $validated['heure_debut'])
                            ->where('heure_fin', '>=', $validated['heure_fin']);
                    });
            })
            ->exists();

        // Vérifier les conflits d'horaire pour le professeur
        $conflitsProfesseur = EmploiDuTemps::where('professeur_id', $validated['professeur_id'])
            ->where('jour', $validated['jour'])
            ->where(function($query) use ($validated) {
                $query->whereBetween('heure_debut', [$validated['heure_debut'], $validated['heure_fin']])
                    ->orWhereBetween('heure_fin', [$validated['heure_debut'], $validated['heure_fin']])
                    ->orWhere(function($q) use ($validated) {
                        $q->where('heure_debut', '<=', $validated['heure_debut'])
                            ->where('heure_fin', '>=', $validated['heure_fin']);
                    });
            })
            ->exists();

        // Vérifier les conflits d'horaire pour la salle
        $conflitsSalle = EmploiDuTemps::where('salle', $validated['salle'])
            ->where('jour', $validated['jour'])
            ->where(function($query) use ($validated) {
                $query->whereBetween('heure_debut', [$validated['heure_debut'], $validated['heure_fin']])
                    ->orWhereBetween('heure_fin', [$validated['heure_debut'], $validated['heure_fin']])
                    ->orWhere(function($q) use ($validated) {
                        $q->where('heure_debut', '<=', $validated['heure_debut'])
                            ->where('heure_fin', '>=', $validated['heure_fin']);
                    });
            })
            ->exists();

        if ($conflitsClasse) {
            return back()->withInput()->with('error', 'Conflit d\'horaire pour cette classe.');
        }

        if ($conflitsProfesseur) {
            return back()->withInput()->with('error', 'Conflit d\'horaire pour ce professeur.');
        }

        if ($conflitsSalle) {
            return back()->withInput()->with('error', 'Conflit d\'horaire pour cette salle.');
        }

        EmploiDuTemps::create($validated);

        return redirect()->route('emploi-du-temps.index', ['classe_id' => $validated['classe_id']])
            ->with('success', 'Cours ajouté à l\'emploi du temps avec succès.');
    }

    public function edit(EmploiDuTemps $emploiDuTemps)
    {
        $classes = Classe::orderBy('niveau', 'asc')
            ->orderBy('nom', 'asc')
            ->get();
        $cours = Cours::orderBy('nom', 'asc')->get();
        $professeurs = Professeur::orderBy('nom', 'asc')
            ->orderBy('prenom', 'asc')
            ->get();
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];

        return view('emploi_du_temps.edit', compact('emploiDuTemps', 'classes', 'cours', 'professeurs', 'jours'));
    }

    public function update(Request $request, EmploiDuTemps $emploiDuTemps)
    {
        $validated = $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'cours_id' => 'required|exists:cours,id',
            'professeur_id' => 'required|exists:professeurs,id',
            'jour' => 'required|in:Lundi,Mardi,Mercredi,Jeudi,Vendredi,Samedi',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'salle' => 'required|string|max:255',
        ]);

        // Vérifier les conflits d'horaire pour la classe
        $conflitsClasse = EmploiDuTemps::where('classe_id', $validated['classe_id'])
            ->where('jour', $validated['jour'])
            ->where('id', '!=', $emploiDuTemps->id)
            ->where(function($query) use ($validated) {
                $query->whereBetween('heure_debut', [$validated['heure_debut'], $validated['heure_fin']])
                    ->orWhereBetween('heure_fin', [$validated['heure_debut'], $validated['heure_fin']])
                    ->orWhere(function($q) use ($validated) {
                        $q->where('heure_debut', '<=', $validated['heure_debut'])
                            ->where('heure_fin', '>=', $validated['heure_fin']);
                    });
            })
            ->exists();

        // Vérifier les conflits d'horaire pour le professeur
        $conflitsProfesseur = EmploiDuTemps::where('professeur_id', $validated['professeur_id'])
            ->where('jour', $validated['jour'])
            ->where('id', '!=', $emploiDuTemps->id)
            ->where(function($query) use ($validated) {
                $query->whereBetween('heure_debut', [$validated['heure_debut'], $validated['heure_fin']])
                    ->orWhereBetween('heure_fin', [$validated['heure_debut'], $validated['heure_fin']])
                    ->orWhere(function($q) use ($validated) {
                        $q->where('heure_debut', '<=', $validated['heure_debut'])
                            ->where('heure_fin', '>=', $validated['heure_fin']);
                    });
            })
            ->exists();

        // Vérifier les conflits d'horaire pour la salle
        $conflitsSalle = EmploiDuTemps::where('salle', $validated['salle'])
            ->where('jour', $validated['jour'])
            ->where('id', '!=', $emploiDuTemps->id)
            ->where(function($query) use ($validated) {
                $query->whereBetween('heure_debut', [$validated['heure_debut'], $validated['heure_fin']])
                    ->orWhereBetween('heure_fin', [$validated['heure_debut'], $validated['heure_fin']])
                    ->orWhere(function($q) use ($validated) {
                        $q->where('heure_debut', '<=', $validated['heure_debut'])
                            ->where('heure_fin', '>=', $validated['heure_fin']);
                    });
            })
            ->exists();

        if ($conflitsClasse) {
            return back()->withInput()->with('error', 'Conflit d\'horaire pour cette classe.');
        }

        if ($conflitsProfesseur) {
            return back()->withInput()->with('error', 'Conflit d\'horaire pour ce professeur.');
        }

        if ($conflitsSalle) {
            return back()->withInput()->with('error', 'Conflit d\'horaire pour cette salle.');
        }

        $emploiDuTemps->update($validated);

        return redirect()->route('emploi-du-temps.index', ['classe_id' => $validated['classe_id']])
            ->with('success', 'Emploi du temps mis à jour avec succès.');
    }

    public function destroy(EmploiDuTemps $emploiDuTemps)
    {
        $classeId = $emploiDuTemps->classe_id;

        $emploiDuTemps->delete();

        return redirect()->route('emploi-du-temps.index', ['classe_id' => $classeId])
            ->with('success', 'Cours supprimé de l\'emploi du temps avec succès.');
    }
}
