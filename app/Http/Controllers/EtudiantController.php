<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Classe;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    public function index()
    {
        $etudiants = Etudiant::with('classe')
            ->orderBy('nom', 'asc')
            ->orderBy('prenom', 'asc')
            ->paginate(10);
        return view('etudiants.index', compact('etudiants'));
    }

    public function create()
    {
        $classes = Classe::orderBy('niveau', 'asc')
            ->orderBy('nom', 'asc')
            ->get();
        return view('etudiants.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:etudiants',
            'telephone' => 'nullable|string|max:20',
            'date_naissance' => 'required|date',
            'numero_etudiant' => 'required|string|max:255|unique:etudiants',
            'classe_id' => 'required|exists:classes,id',
        ]);

        Etudiant::create($validated);

        return redirect()->route('etudiants.index')
            ->with('success', 'Étudiant créé avec succès.');
    }

    public function show(Etudiant $etudiant)
    {
        return view('etudiants.show', compact('etudiant'));
    }

    public function edit(Etudiant $etudiant)
    {
        $classes = Classe::orderBy('niveau', 'asc')
            ->orderBy('nom', 'asc')
            ->get();
        return view('etudiants.edit', compact('etudiant', 'classes'));
    }

    public function update(Request $request, Etudiant $etudiant)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:etudiants,email,' . $etudiant->id,
            'telephone' => 'nullable|string|max:20',
            'date_naissance' => 'required|date',
            'numero_etudiant' => 'required|string|max:255|unique:etudiants,numero_etudiant,' . $etudiant->id,
            'classe_id' => 'required|exists:classes,id',
        ]);

        $etudiant->update($validated);

        return redirect()->route('etudiants.index')
            ->with('success', 'Étudiant mis à jour avec succès.');
    }

    public function destroy(Etudiant $etudiant)
    {
        try {
            $etudiant->delete();
            return redirect()->route('etudiants.index')
                ->with('success', 'Étudiant supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('etudiants.index')
                ->with('error', 'Impossible de supprimer cet étudiant.');
        }
    }
}
