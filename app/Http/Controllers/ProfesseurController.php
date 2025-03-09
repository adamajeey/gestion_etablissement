<?php

namespace App\Http\Controllers;

use App\Models\Professeur;
use Illuminate\Http\Request;

class ProfesseurController extends Controller
{
    public function index()
    {
        $professeurs = Professeur::orderBy('nom', 'asc')
            ->orderBy('prenom', 'asc')
            ->paginate(10);
        return view('professeurs.index', compact('professeurs'));
    }

    public function create()
    {
        return view('professeurs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:professeurs',
            'telephone' => 'nullable|string|max:20',
            'specialite' => 'required|string|max:255',
            'date_embauche' => 'required|date',
        ]);

        Professeur::create($validated);

        return redirect()->route('professeurs.index')
            ->with('success', 'Professeur créé avec succès.');
    }

    public function show(Professeur $professeur)
    {
        $emploisDuTemps = $professeur->emploisDuTemps()
            ->with(['classe', 'cours'])
            ->get();

        return view('professeurs.show', compact('professeur', 'emploisDuTemps'));
    }

    public function edit(Professeur $professeur)
    {
        return view('professeurs.edit', compact('professeur'));
    }

    public function update(Request $request, Professeur $professeur)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:professeurs,email,' . $professeur->id,
            'telephone' => 'nullable|string|max:20',
            'specialite' => 'required|string|max:255',
            'date_embauche' => 'required|date',
        ]);

        $professeur->update($validated);

        return redirect()->route('professeurs.index')
            ->with('success', 'Professeur mis à jour avec succès.');
    }

    public function destroy(Professeur $professeur)
    {
        try {
            $professeur->delete();
            return redirect()->route('professeurs.index')
                ->with('success', 'Professeur supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('professeurs.index')
                ->with('error', 'Impossible de supprimer ce professeur car il est associé à des emplois du temps.');
        }
    }
}
