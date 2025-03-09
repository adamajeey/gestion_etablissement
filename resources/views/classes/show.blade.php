@extends('layouts.app')

@section('title', 'Détails de la Classe')

@section('content')
    <div class="row mb-4">
        <div class="col-md-8">
            <h1><i class="fas fa-chalkboard me-2"></i>{{ $classe->nom }}</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('classes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retour
            </a>
            <a href="{{ route('classes.edit', $classe) }}" class="btn btn-warning text-white">
                <i class="fas fa-edit me-2"></i>Modifier
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5><i class="fas fa-info-circle me-2"></i>Informations générales</h5>
                </div>
                <div class="card-body">
                    <p><strong>Niveau:</strong> {{ $classe->niveau }}</p>
                    <p><strong>Capacité:</strong> {{ $classe->capacite }}</p>
                    <p><strong>Nombre d'étudiants:</strong> {{ $classe->etudiants->count() }}</p>
                    <p><strong>Description:</strong> {{ $classe->description ?: 'Aucune description' }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-book me-2"></i>Cours associés</h5>
                </div>
                <div class="card-body">
                    @if ($cours->count() > 0)
                        <ul class="list-group">
                            @foreach ($cours as $c)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $c->nom }}
                                    <span class="badge bg-primary rounded-pill">{{ $c->credits }} crédits</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-center">Aucun cours associé à cette classe</p>
                    @endif

                    <div class="mt-3">
                        <a href="{{ route('emploi-du-temps.index', ['classe_id' => $classe->id]) }}" class="btn btn-primary w-100">
                            <i class="fas fa-calendar-alt me-2"></i>Voir l'emploi du temps
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-user-graduate me-2"></i>Liste des étudiants</h5>
                    <a href="{{ route('etudiants.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus-circle me-2"></i>Ajouter un étudiant
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Numéro</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($etudiants as $etudiant)
                                <tr>
                                    <td>{{ $etudiant->numero_etudiant }}</td>
                                    <td>{{ $etudiant->nom_complet }}</td>
                                    <td>{{ $etudiant->email }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('etudiants.show', $etudiant) }}" class="btn btn-sm btn-info text-white">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('etudiants.edit', $etudiant) }}" class="btn btn-sm btn-warning text-white">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Aucun étudiant dans cette classe</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $etudiants->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
