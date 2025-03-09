@extends('layouts.app')

@section('title', 'Gestion des Emplois du Temps')

@section('content')
    <div class="row mb-4">
        <div class="col-md-8">
            <h1><i class="fas fa-calendar-alt me-2"></i>Gestion des Emplois du Temps</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('emploi-du-temps.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Ajouter un cours
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5><i class="fas fa-filter me-2"></i>Sélectionner une classe</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('emploi-du-temps.index') }}" method="GET" class="row g-3">
                <div class="col-md-10">
                    <select name="classe_id" class="form-select" required>
                        <option value="">-- Sélectionner une classe --</option>
                        @foreach($classes as $c)
                            <option value="{{ $c->id }}" {{ isset($classe) && $classe->id == $c->id ? 'selected' : '' }}>
                                {{ $c->niveau }} - {{ $c->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Afficher
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(isset($classe))
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-calendar-week me-2"></i>Emploi du temps: {{ $classe->niveau }} - {{ $classe->nom }}</h5>
            </div>
            <div class="card-body">
                @foreach($jours as $jour)
                    <h5 class="mt-4 mb-3 text-primary"><i class="fas fa-calendar-day me-2"></i>{{ $jour }}</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                            <tr>
                                <th width="15%">Horaire</th>
                                <th width="20%">Cours</th>
                                <th width="20%">Professeur</th>
                                <th width="15%">Salle</th>
                                <th width="15%">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($emploiParJour[$jour]) && $emploiParJour[$jour]->count() > 0)
                                @foreach($emploiParJour[$jour] as $emploi)
                                    <tr>
                                        <td>{{ substr($emploi->heure_debut, 0, 5) }} - {{ substr($emploi->heure_fin, 0, 5) }}</td>
                                        <td>{{ $emploi->cours->nom }}</td>
                                        <td>{{ $emploi->professeur->nom_complet }}</td>
                                        <td>{{ $emploi->salle }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('emploi-du-temps.edit', $emploi) }}" class="btn btn-sm btn-warning text-white">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $emploi->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>

                                            <!-- Modal de confirmation de suppression -->
                                            <div class="modal fade" id="deleteModal{{ $emploi->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirmer la suppression</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Êtes-vous sûr de vouloir supprimer ce cours de l'emploi du temps ?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                            <form action="{{ route('emploi-du-temps.destroy', $emploi) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Supprimer</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">Aucun cours pour ce jour</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection
