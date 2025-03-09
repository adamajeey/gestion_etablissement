@extends('layouts.app')

@section('title', 'Ajouter un cours à l\'emploi du temps')

@section('content')
    <div class="row mb-4">
        <div class="col-md-8">
            <h1><i class="fas fa-plus-circle me-2"></i>Ajouter un cours à l'emploi du temps</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('emploi-du-temps.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Retour
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('emploi-du-temps.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="classe_id" class="form-label">Classe</label>
                        <select class="form-select @error('classe_id') is-invalid @enderror" id="classe_id" name="classe_id" required>
                            <option value="">-- Sélectionner une classe --</option>
                            @foreach($classes as $classe)
                                <option value="{{ $classe->id }}" {{ old('classe_id') == $classe->id ? 'selected' : '' }}>
                                    {{ $classe->niveau }} - {{ $classe->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('classe_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="cours_id" class="form-label">Cours</label>
                        <select class="form-select @error('cours_id') is-invalid @enderror" id="cours_id" name="cours_id" required>
                            <option value="">-- Sélectionner un cours --</option>
                            @foreach($cours as $c)
                                <option value="{{ $c->id }}" {{ old('cours_id') == $c->id ? 'selected' : '' }}>
                                    {{ $c->nom }} ({{ $c->code_cours }})
                                </option>
                            @endforeach
                        </select>
                        @error('cours_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="professeur_id" class="form-label">Professeur</label>
                        <select class="form-select @error('professeur_id') is-invalid @enderror" id="professeur_id" name="professeur_id" required>
                            <option value="">-- Sélectionner un professeur --</option>
                            @foreach($professeurs as $professeur)
                                <option value="{{ $professeur->id }}" {{ old('professeur_id') == $professeur->id ? 'selected' : '' }}>
                                    {{ $professeur->nom_complet }} ({{ $professeur->specialite }})
                                </option>
                            @endforeach
                        </select>
                        @error('professeur_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="jour" class="form-label">Jour</label>
                        <select class="form-select @error('jour') is-invalid @enderror" id="jour" name="jour" required>
                            <option value="">-- Sélectionner un jour --</option>
                            @foreach($jours as $jour)
                                <option value="{{ $jour }}" {{ old('jour') == $jour ? 'selected' : '' }}>
                                    {{ $jour }}
                                </option>
                            @endforeach
                        </select>
                        @error('jour')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="heure_debut" class="form-label">Heure de début</label>
                        <input type="time" class="form-control @error('heure_debut') is-invalid @enderror" id="heure_debut" name="heure_debut" value="{{ old('heure_debut') }}" required>
                        @error('heure_debut')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="heure_fin" class="form-label">Heure de fin</label>
                        <input type="time" class="form-control @error('heure_fin') is-invalid @enderror" id="heure_fin" name="heure_fin" value="{{ old('heure_fin') }}" required>
                        @error('heure_fin')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="salle" class="form-label">Salle</label>
                        <input type="text" class="form-control @error('salle') is-invalid @enderror" id="salle" name="salle" value="{{ old('salle') }}" required>
                        @error('salle')
                        <div class="invalid-feedback">{{ $message }}</div>
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
