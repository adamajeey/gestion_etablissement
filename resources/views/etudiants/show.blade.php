@extends('layouts.app')

@section('title', 'Détails de l\'Étudiant')

@section('content')
    <div class="row mb-4">
        <div class="col-md-8">
            <h1><i class="fas fa-user-graduate me-2"></i>{{ $etudiant->nom_complet }}</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('etudiants.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retour
            </a>
            <a href="{{ route('etudiants.edit', $etudiant) }}" class="btn btn-warning text-white">
                <i class="fas fa-edit me-2"></i>Modifier
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5><i class="fas fa-info-circle me-2"></i>Informations personnelles</h5>
                </div>
                <div class="card-body">
                    <p><strong>Numéro d'étudiant:</strong> {{ $etudiant->numero_etudiant }}</p>
                    <p><strong>Email:</strong> {{ $etudiant->email }}</p>
                    <p><strong>Téléphone:</strong> {{ $etudiant->telephone ?: 'Non spécifié' }}</p>
                    <p><strong>Date de naissance:</strong> {{ \Carbon\Carbon::parse($etudiant->date_naissance)->format('d/m/Y') }}</p>
                    <p><strong>Âge:</strong> {{ \Carbon\Carbon::parse($etudiant->date_naissance)->age }} ans</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5><i class="fas fa-chalkboard me-2"></i>Informations académiques</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="fw-bold">Classe actuelle:</h6>
                        <div class="p-3 border rounded">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Niveau:</strong> {{ $etudiant->classe->niveau }}</p>
                                    <p class="mb-1"><strong>Nom:</strong> {{ $etudiant->classe->nom }}</p>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <a href="{{ route('classes.show', $etudiant->classe) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye me-1"></i>Voir la classe
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6 class="fw-bold">Cours suivis:</h6>
                    @php
                        $cours = $etudiant->classe->cours;
                    @endphp

                    @if ($cours->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Nom</th>
                                    <th>Crédits</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($cours as $c)
                                    <tr>
                                        <td>{{ $c->code_cours }}</td>
                                        <td>{{ $c->nom }}</td>
                                        <td>{{ $c->credits }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center">Aucun cours associé à cette classe</p>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-calendar-alt me-2"></i>Emploi du temps</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('emploi-du-temps.index', ['classe_id' => $etudiant->classe_id]) }}" class="btn btn-primary">
                        <i class="fas fa-calendar-week me-2"></i>Voir l'emploi du temps de la classe
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
