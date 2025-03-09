@extends('layouts.app')

@section('title', 'Gestion des Cours')

@section('content')
    <div class="row mb-4">
        <div class="col-md-8">
            <h1><i class="fas fa-book me-2"></i>Gestion des Cours</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('cours.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Ajouter un cours
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Code</th>
                        <th>Nom</th>
                        <th>Crédits</th>
                        <th>Nb. Classes</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($cours as $c)
                        <tr>
                            <td>{{ $c->code_cours }}</td>
                            <td>{{ $c->nom }}</td>
                            <td>{{ $c->credits }}</td>
                            <td>{{ $c->classes->count() }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('cours.show', $c) }}" class="btn btn-sm btn-info text-white">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('cours.edit', $c) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $c->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <!-- Modal de confirmation de suppression -->
                                <div class="modal fade" id="deleteModal{{ $c->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirmer la suppression</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Êtes-vous sûr de vouloir supprimer le cours <strong>{{ $c->nom }}</strong> ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                <form action="{{ route('cours.destroy', $c) }}" method="POST">
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
                            <td colspan="5" class="text-center">Aucun cours trouvé</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $cours->links() }}
            </div>
        </div>
    </div>
@endsection
