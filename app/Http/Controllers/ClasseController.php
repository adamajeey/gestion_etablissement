<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    public function index()
    {
        $classes = Classe::orderBy('niveau', 'asc')
            ->orderBy('nom', 'asc')
            ->paginate(10);
        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        return view('classes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'niveau' => 'required|string|max:255',
            'capacite' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        Classe::create($validated);

        return redirect()->route('classes.index')
            ->with('success', 'Classe créée avec succès.');
    }

    public function show(Classe $classe)
    {
        $etudiants = $classe->etudiants()->paginate(10);
        $cours = $classe->cours;

        return view('classes.show', compact('classe', 'etudiants', 'cours'));
    }

    public function edit(Classe $classe)
    {
        return view('classes.edit', compact('classe'));
    }

    public function update(Request $request, Classe $classe)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'niveau' => 'required|string|max:255',
            'capacite' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $classe->update($validated);

        return redirect()->route('classes.index')
            ->with('success', 'Classe mise à jour avec succès.');
    }

    public function destroy(Classe $classe)
    {
        try {
            $classe->delete();
            return redirect()->route('classes.index')
                ->with('success', 'Classe supprimée avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('classes.index')
                ->with('error', 'Impossible de supprimer cette classe car elle contient des étudiants ou des cours associés.');
        }
    }
}
