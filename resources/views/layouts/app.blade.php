<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - @yield('title', 'Accueil')</title>
    <!-- Favicon -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/scrumboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dt_global_style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS avec Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <script
    src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Styles supplémentaires -->
    @stack('styles')
</head>
<body class="layout-boxed">
    <!-- Inclure la barre latérale -->
    @include('inc.sidebar')
    
    <div class="main-container">
        <!-- Contenu principal -->
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-white">
                <div class="container">
                    <!-- Bouton pour basculer la barre latérale sur mobile -->
                    <button class="navbar-toggler toggle-sidebar d-lg-none" type="button">
                        <i class="bi bi-list"></i>
                    </button>
                    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <!-- Contenu de la navbar -->
                    <div class="collapse navbar-collapse" id="navbarContent">
                        <!-- ... le reste de votre navbar ... -->
                    </div>
                </div>
            </nav>
        </header>
        
        <main class="main-content">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>
    
    <!-- Scripts -->
    <script>
        // Script pour basculer la barre latérale
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButtons = document.querySelectorAll('.toggle-sidebar');
            const sidebar = document.querySelector('.sidebar-wrapper');
            const mainContainer = document.querySelector('.main-container');
            
            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                });
            });
            
            // Fonction pour basculer en mode mini
            const toggleMiniSidebar = document.querySelector('.toggle-mini-sidebar');
            if (toggleMiniSidebar) {
                toggleMiniSidebar.addEventListener('click', function() {
                    sidebar.classList.toggle('mini');
                    mainContainer.classList.toggle('expanded');
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
