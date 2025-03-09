@extends('layouts.app')

@section('title', 'Modifier un Cours')

@section('content')
    <div class="row mb-4">
        <div class="col-md-8">
            <h1><i class="fas fa-edit me-2"></i>Modifier le Cours</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('cours.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retour
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('cours.update', $cours) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nom" class="form-label">Nom du cours</label>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom', $cours->nom) }}" required>
                        @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="code_cours" class="form-label">Code du cours</label>
                        <input type="text" class="form-control @error('code_cours') is-invalid @enderror" id="code_cours" name="code_cours" value="{{ old('code_cours', $cours->code_cours) }}" required>
                        @error('code_cours')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $cours->description) }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="credits" class="form-label">Crédits</label>
                        <input type="number" class="form-control @error('credits') is-invalid @enderror" id="credits" name="credits" value="{{ old('credits', $cours->credits) }}" min="1" required>
                        @error('credits')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Classes associées</label>
                        <div class="card">
                            <div class="card-body" style="max-height: 200px; overflow-y: auto;">
                                @foreach($classes as $classe)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="classes[]" value="{{ $classe->id }}" id="classe{{ $classe->id }}"
                                            {{ in_array($classe->id, old('classes', $selectedClasses)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="classe{{ $classe->id }}">
                                            {{ $classe->niveau }} - {{ $classe->nom }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @error('classes')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
