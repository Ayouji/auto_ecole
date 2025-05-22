<!-- Sidebar -->
<div class="sidebar-wrapper">
    <!-- Logo/Brand -->
    <div class="sidebar-brand">
        <img src="/qvct-consulting.png" width="210px">
    </div>

    <!-- Menu Items -->
    <div class="sidebar-menu">
        <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2 text-primary"></i>
            <span class="menu-text">Tableau de bord</span>
        </a>
        
        <!-- Section Moniteur -->
        @if(Auth::user()->isMoniteur())
            <div class="menu-category">
                <span>Gestion des Ressources</span>
            </div>
            
            <a href="{{ route('monitor.series.index') }}" class="menu-item {{ request()->routeIs('monitor.series.*') ? 'active' : '' }}">
                <i class="bi bi-tags text-primary"></i>
                <span class="menu-text">Séries</span>
            </a>
            
            <a href="{{ route('monitor.questions.index') }}" class="menu-item {{ request()->routeIs('monitor.questions.*') ? 'active' : '' }}">
                <i class="bi bi-question-circle text-primary"></i>
                <span class="menu-text">Questions</span>
            </a>
            
            <a href="{{ route('monitor.courses.index') }}" class="menu-item {{ request()->routeIs('monitor.courses.*') ? 'active' : '' }}">
                <i class="bi bi-book text-primary"></i>
                <span class="menu-text">Cours</span>
            </a>
            
            <a href="{{ route('monitor.exams.index') }}" class="menu-item {{ request()->routeIs('monitor.exams.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text text-primary"></i>
                <span class="menu-text">Examens</span>
            </a>
            
            <div class="menu-category">
                <span>Gestion des Utilisateurs</span>
            </div>
            
            <a href="{{ route('monitor.users.index') }}" class="menu-item {{ request()->routeIs('monitor.users.*') ? 'active' : '' }}">
                <i class="bi bi-people text-primary"></i>
                <span class="menu-text">Élèves</span>
            </a>
            
            <a href="" class="menu-item ">
                <i class="bi bi-bar-chart text-primary"></i>
                <span class="menu-text">Statistiques</span>
            </a>
        @else
            <!-- Section Élève -->
            <div class="menu-category">
                <span>Apprentissage</span>
            </div>
            
            <a href="{{ route('eleve.series.index') }}" class="menu-item {{ request()->routeIs('eleve.series.*') ? 'active' : '' }}">
                <i class="bi bi-tags text-success"></i>
                <span class="menu-text">Séries d'entraînement</span>
            </a>
            
            <a href="{{ route('eleve.courses.index') }}" class="menu-item {{ request()->routeIs('eleve.courses.*') ? 'active' : '' }}">
                <i class="bi bi-book text-success"></i>
                <span class="menu-text">Cours</span>
            </a>
            
            <a href="{{ route('eleve.exams.index') }}" class="menu-item {{ request()->routeIs('eleve.exams.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text text-success"></i>
                <span class="menu-text">Examens</span>
            </a>
            
            <div class="menu-category">
                <span>Mon Compte</span>
            </div>
            
            <a href="{{ route('eleve.profile.index') }}" class="menu-item {{ request()->routeIs('eleve.profile.*') ? 'active' : '' }}">
                <i class="bi bi-person text-success"></i>
                <span class="menu-text">Mon profil</span>
            </a>
            
            <a href="{{ route('eleve.progress.index') }}" class="menu-item {{ request()->routeIs('eleve.progress.*') ? 'active' : '' }}">
                <i class="bi bi-graph-up text-success"></i>
                <span class="menu-text">Ma progression</span>
            </a>
        @endif
    </div>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <a href="{{ route('profile.edit') }}" class="menu-item">
            <i class="bi bi-gear text-secondary"></i>
            <span class="menu-text">Paramètres</span>
        </a>
        
        <a href="{{ route('logout') }}" class="menu-item"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right text-danger"></i>
            <span class="menu-text">Déconnexion</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</div>

<!-- Ajoutez ce CSS dans votre fichier sidebar.css ou directement ici -->
<style>
    .menu-category {
        padding: 0.75rem 1.5rem 0.5rem;
        font-size: 0.8rem;
        text-transform: uppercase;
        color: #6c757d;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .sidebar-wrapper.mini .menu-category {
        display: none;
    }
</style>