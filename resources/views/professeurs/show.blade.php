@extends('layouts.app')

@section('title', 'Détails du Professeur')

@section('content')
    <div class="row mb-4">
        <div class="col-md-8">
            <h1><i class="fas fa-chalkboard-teacher me-2"></i>{{ $professeur->nom_complet }}</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('professeurs.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retour
            </a>
            <a href="{{ route('professeurs.edit', $professeur) }}" class="btn btn-warning text-white">
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
                    <p><strong>Email:</strong> {{ $professeur->email }}</p>
                    <p><strong>Téléphone:</strong> {{ $professeur->telephone ?: 'Non spécifié' }}</p>
                    <p><strong>Spécialité:</strong> {{ $professeur->specialite }}</p>
                    <p><strong>Date d'embauche:</strong> {{ \Carbon\Carbon::parse($professeur->date_embauche)->format('d/m/Y') }}</p>
                    <p><strong>Ancienneté:</strong> {{ \Carbon\Carbon::parse($professeur->date_embauche)->diffForHumans(null, true) }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-calendar-alt me-2"></i>Emploi du temps</h5>
                </div>
                <div class="card-body">
                    @if ($emploisDuTemps->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Jour</th>
                                    <th>Horaire</th>
                                    <th>Classe</th>
                                    <th>Cours</th>
                                    <th>Salle</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($emploisDuTemps as $emploi)
                                    <tr>
                                        <td>{{ $emploi->jour }}</td>
                                        <td>{{ substr($emploi->heure_debut, 0, 5) }} - {{ substr($emploi->heure_fin, 0, 5) }}</td>
                                        <td>{{ $emploi->classe->nom }}</td>
                                        <td>{{ $emploi->cours->nom }}</td>
                                        <td>{{ $emploi->salle }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center">Aucun cours planifié pour ce professeur</p>
                    @endif

                    <div class="mt-3">
                        <a href="{{ route('emploi-du-temps.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>Ajouter un cours
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
