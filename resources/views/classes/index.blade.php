@extends('layouts.app')

@section('title', 'Gestion des Classes')

@section('content')
    <div class="row mb-4">
        <div class="col-md-8">
            <h1><i class="fas fa-chalkboard me-2"></i>Gestion des Classes</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('classes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Ajouter une classe
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Niveau</th>
                        <th>Capacité</th>
                        <th>Nombre d'étudiants</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($classes as $classe)
                        <tr>
                            <td>{{ $classe->id }}</td>
                            <td>{{ $classe->nom }}</td>
                            <td>{{ $classe->niveau }}</td>
                            <td>{{ $classe->capacite }}</td>
                            <td>{{ $classe->etudiants->count() }} / {{ $classe->capacite }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('classes.show', $classe) }}" class="btn btn-sm btn-info text-white">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('classes.edit', $classe) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $classe->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <!-- Modal de confirmation de suppression -->
                                <div class="modal fade" id="deleteModal{{ $classe->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirmer la suppression</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Êtes-vous sûr de vouloir supprimer la classe <strong>{{ $classe->nom }}</strong> ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                <form action="{{ route('classes.destroy', $classe) }}" method="POST">
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
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Aucune classe trouvée</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $classes->links() }}
            </div>
        </div>
    </div>
@endsection
