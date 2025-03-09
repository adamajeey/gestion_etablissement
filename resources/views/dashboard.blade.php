@extends('layouts.app')

@section('title', 'Tableau de bord - Gestion d\'établissement')

@section('content')
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="mb-4">
                <i class="fas fa-tachometer-alt me-2"></i>Tableau de bord
            </h1>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card dashboard-stat bg-primary text-white">
                <div class="card-body">
                    <h3>{{ $totalClasses }}</h3>
                    <p><i class="fas fa-chalkboard me-2"></i>Classes</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card dashboard-stat" style="background-color: #2897e8;">
                <div class="card-body">
                    <h3>{{ $totalCours }}</h3>
                    <p><i class="fas fa-book me-2"></i>Cours</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card dashboard-stat" style="background-color: #2897e8;">
                <div class="card-body">
                    <h3>{{ $totalEtudiants }}</h3>
                    <p><i class="fas fa-user-graduate me-2"></i>Étudiants</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card dashboard-stat bg-primary text-white">
                <div class="card-body">
                    <h3>{{ $totalProfesseurs }}</h3>
                    <p><i class="fas fa-chalkboard-teacher me-2"></i>Professeurs</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-calendar-day me-2"></i>Cours du jour ({{ $aujourdhuiJour }})</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Horaire</th>
                                <th>Classe</th>
                                <th>Cours</th>
                                <th>Professeur</th>
                                <th>Salle</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($emploisDuJour as $emploi)
                                <tr>
                                    <td>{{ substr($emploi->heure_debut, 0, 5) }} - {{ substr($emploi->heure_fin, 0, 5) }}</td>
                                    <td>{{ $emploi->classe->nom }}</td>
                                    <td>{{ $emploi->cours->nom }}</td>
                                    <td>{{ $emploi->professeur->nom_complet }}</td>
                                    <td>{{ $emploi->salle }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Aucun cours aujourd'hui</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-chart-pie me-2"></i>Classes les plus populaires</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Classe</th>
                                <th>Niveau</th>
                                <th>Nombre d'étudiants</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($classesPopulaires as $classe)
                                <tr>
                                    <td>{{ $classe->nom }}</td>
                                    <td>{{ $classe->niveau }}</td>
                                    <td>{{ $classe->etudiants_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Aucune donnée disponible</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-tasks me-2"></i>Actions rapides</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('classes.create') }}" class="btn btn-primary w-100">
                                <i class="fas fa-plus-circle me-2"></i>Ajouter une classe
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('cours.create') }}" class="btn btn-primary w-100">
                                <i class="fas fa-plus-circle me-2"></i>Ajouter un cours
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('etudiants.create') }}" class="btn btn-primary w-100">
                                <i class="fas fa-plus-circle me-2"></i>Ajouter un étudiant
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('professeurs.create') }}" class="btn btn-primary w-100">
                                <i class="fas fa-plus-circle me-2"></i>Ajouter un professeur
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

