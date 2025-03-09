<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestion d\'établissement')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- CSS personnalisé -->
    <style>
        :root {
            --couleur-principale: #2897e8;
            --couleur-secondaire: #1a6ca8;
        }

        body {
            background-color: #f8f9fa;
            color: #333;
            font-family: 'Nunito', sans-serif;
        }

        .navbar {
            background-color: var(--couleur-principale);
        }

        .navbar-dark .navbar-brand, .navbar-dark .nav-link {
            color: white;
        }

        .navbar-dark .nav-link.active {
            font-weight: bold;
        }

        .btn-primary {
            background-color: var(--couleur-principale);
            border-color: var(--couleur-principale);
        }

        .dashboard-stat {
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            color: white;
        }

        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
    </style>

    @yield('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <i class="fas fa-school me-2"></i>
            Gestion d'Établissement
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt me-1"></i> Tableau de bord
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('classes.*') ? 'active' : '' }}" href="{{ route('classes.index') }}">
                        <i class="fas fa-chalkboard me-1"></i> Classes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('cours.*') ? 'active' : '' }}" href="{{ route('cours.index') }}">
                        <i class="fas fa-book me-1"></i> Cours
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('etudiants.*') ? 'active' : '' }}" href="{{ route('etudiants.index') }}">
                        <i class="fas fa-user-graduate me-1"></i> Étudiants
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('professeurs.*') ? 'active' : '' }}" href="{{ route('professeurs.index') }}">
                        <i class="fas fa-chalkboard-teacher me-1"></i> Professeurs
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('emploi-du-temps.*') ? 'active' : '' }}" href="{{ route('emploi-du-temps.index') }}">
                        <i class="fas fa-calendar-alt me-1"></i> Emploi du temps
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mb-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @yield('content')
</div>

<footer class="bg-dark text-white py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h5>Gestion d'Établissement</h5>
                <p>Une application de gestion complète pour les établissements d'enseignement.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <p>&copy; {{ date('Y') }} - Tous droits réservés</p>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')
</body>
</html>
