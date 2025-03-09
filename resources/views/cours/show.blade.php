@extends('layouts.app')

@section('title', 'Détails du Cours')

@section('content')
    <div class="row mb-4">
        <div class="col-md-8">
            <h1><i class="fas fa-book me-2"></i>{{ $cours->nom }}</h1>
            <h5 class="text-muted">Code: {{ $cours->code_cours }}</h5>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('cours.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retour
            </a>
            <a href="{{ route('cours.edit', $cours) }}" class="btn btn-warning text-white">
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
                    <p><strong>Crédits:</strong> {{ $cours->credits }}</p>
                    <p><strong>Description:</strong> {{ $cours->description ?: 'Aucune description' }}</p>
                    <p><strong>Nombre de classes:</strong> {{ $classes->count() }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-chalkboard me-2"></i>Classes associées</h5>
                </div>
                <div class="card-body">
                    @if ($classes->count() > 0)
                        <ul class="list-group">
                            @foreach ($classes as $classe)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $classe->niveau }} - {{ $classe->nom }}
                                    <span class="badge bg-primary rounded-pill">{{ $classe->etudiants->count() }} étudiants</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-center">Ce cours n'est associé à aucune classe</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-calendar-alt me-2"></i>Planification du cours</h5>
                </div>
                <div class="card-body">
                    @php
                        $emploisDuTemps = App\Models\EmploiDuTemps::where('cours_id', $cours->id)
                                            ->with(['classe', 'professeur'])
                                            ->orderBy('jour')
                                            ->orderBy('heure_debut')
                                            ->get();
                    @endphp

                    @if ($emploisDuTemps->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Jour</th>
                                    <th>Horaire</th>
                                    <th>Classe</th>
                                    <th>Professeur</th>
                                    <th>Salle</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($emploisDuTemps as $emploi)
                                    <tr>
                                        <td>{{ $emploi->jour }}</td>
                                        <td>{{ substr($emploi->heure_debut, 0, 5) }} - {{ substr($emploi->heure_fin, 0, 5) }}</td>
                                        <td>{{ $emploi->classe->nom }}</td>
                                        <td>{{ $emploi->professeur->nom_complet }}</td>
                                        <td>{{ $emploi->salle }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center">Ce cours n'est pas encore planifié dans l'emploi du temps</p>
                    @endif

                    <div class="mt-3">
                        <a href="{{ route('emploi-du-temps.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>Planifier ce cours
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
