@extends('layouts.app')

@section('content')
<div class="row">
    <!-- Sidebar -->
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-header {{ Auth::user()->isMoniteur() ? 'bg-primary' : 'bg-success' }} text-white">
                <h5 class="mb-0">
                    @if(Auth::user()->isMoniteur())
                        <i class="fas fa-user-tie me-2"></i> Espace Moniteur
                    @else
                        <i class="fas fa-user-graduate me-2"></i> Espace Élève
                    @endif
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @if(Auth::user()->isMoniteur())
                        <a href="{{ route('monitor.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('monitor.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Tableau de bord
                        </a>
                        <a href="{{ route('monitor.series.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('monitor.series.*') ? 'active' : '' }}">
                            <i class="fas fa-layer-group me-2"></i> Séries
                        </a>
                        <a href="{{ route('monitor.questions.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('monitor.questions.*') ? 'active' : '' }}">
                            <i class="fas fa-question-circle me-2"></i> Questions
                        </a>
                        <a href="{{ route('monitor.courses.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('monitor.courses.*') ? 'active' : '' }}">
                            <i class="fas fa-book me-2"></i> Cours
                        </a>
                        <a href="{{ route('monitor.exams.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('monitor.exams.*') ? 'active' : '' }}">
                            <i class="fas fa-file-alt me-2"></i> Examens
                        </a>
                        <a href="{{ route('monitor.users.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('monitor.users.*') ? 'active' : '' }}">
                            <i class="fas fa-users me-2"></i> Élèves
                        </a>
                    @else
                        <a href="{{ route('eleve.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('eleve.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Tableau de bord
                        </a>
                        <a href="{{ route('eleve.series.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('eleve.series.*') ? 'active' : '' }}">
                            <i class="fas fa-layer-group me-2"></i> Séries
                        </a>
                        <a href="{{ route('eleve.courses.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('eleve.courses.*') ? 'active' : '' }}">
                            <i class="fas fa-book me-2"></i> Cours
                        </a>
                        <a href="{{ route('eleve.exams.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('eleve.exams.*') ? 'active' : '' }}">
                            <i class="fas fa-file-alt me-2"></i> Examens
                        </a>
                        <a href="{{ route('eleve.profile.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('eleve.profile.*') ? 'active' : '' }}">
                            <i class="fas fa-user me-2"></i> Mon profil
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="col-md-9">
        @yield('dashboard-content')
    </div>
</div>
@endsection