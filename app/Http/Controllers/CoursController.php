<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\Classe;
use Illuminate\Http\Request;

class CoursController extends Controller
{
    public function index()
    {
        $cours = Cours::orderBy('nom', 'asc')->paginate(10);
        return view('cours.index', compact('cours'));
    }

    public function create()
    {
        $classes = Classe::orderBy('niveau', 'asc')
            ->orderBy('nom', 'asc')
            ->get();
        return view('cours.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'credits' => 'required|integer|min:1',
            'code_cours' => 'required|string|max:255|unique:cours',
            'classes' => 'array',
        ]);

        $cours = Cours::create([
            'nom' => $validated['nom'],
            'description' => $validated['description'],
            'credits' => $validated['credits'],
            'code_cours' => $validated['code_cours'],
        ]);

        if (isset($validated['classes'])) {
            $cours->classes()->attach($validated['classes']);
        }

        return redirect()->route('cours.index')
            ->with('success', 'Cours créé avec succès.');
    }

    public function show(Cours $cours)
    {
        $classes = $cours->classes;

        return view('cours.show', compact('cours', 'classes'));
    }

    public function edit(Cours $cours)
    {
        $classes = Classe::orderBy('niveau', 'asc')
            ->orderBy('nom', 'asc')
            ->get();
        $selectedClasses = $cours->classes->pluck('id')->toArray();

        return view('cours.edit', compact('cours', 'classes', 'selectedClasses'));
    }

    public function update(Request $request, Cours $cours)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'credits' => 'required|integer|min:1',
            'code_cours' => 'required|string|max:255|unique:cours,code_cours,' . $cours->id,
            'classes' => 'array',
        ]);

        $cours->update([
            'nom' => $validated['nom'],
            'description' => $validated['description'],
            'credits' => $validated['credits'],
            'code_cours' => $validated['code_cours'],
        ]);

        if (isset($validated['classes'])) {
            $cours->classes()->sync($validated['classes']);
        } else {
            $cours->classes()->detach();
        }

        return redirect()->route('cours.index')
            ->with('success', 'Cours mis à jour avec succès.');
    }

    public function destroy(Cours $cours)
    {
        try {
            $cours->classes()->detach();
            $cours->delete();
            return redirect()->route('cours.index')
                ->with('success', 'Cours supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('cours.index')
                ->with('error', 'Impossible de supprimer ce cours car il est associé à des emplois du temps.');
        }
    }
}
