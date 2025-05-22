@extends('layouts.app')

@section('title', 'Tableau de bord Moniteur')

@section('content')
<style>
    :root {
        --primary: #3b82f6;
        --primary-dark: #2563eb;
        --secondary: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-600: #4b5563;
        --gray-800: #1f2937;
        --gray-900: #111827;
    }
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    body {
        background-color: #f8fafc;
        color: var(--gray-800);
    }
    
    .dashboard {
        display: grid;
        grid-template-columns: 240px 1fr;
        min-height: 100vh;
    }
    
    /* Sidebar */
    .sidebar {
        background-color: var(--gray-900);
        color: white;
        padding: 1.5rem;
        position: fixed;
        width: 240px;
        height: 100vh;
        overflow-y: auto;
    }
    
    .sidebar-logo {
        display: flex;
        align-items: center;
        margin-bottom: 2rem;
    }
    
    .sidebar-logo img {
        width: 40px;
        height: 40px;
        margin-right: 0.75rem;
    }
    
    .sidebar-logo h2 {
        font-size: 1.25rem;
        font-weight: 600;
    }
    
    .sidebar-menu {
        margin-top: 2rem;
    }
    
    .menu-title {
        text-transform: uppercase;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--gray-300);
        margin-bottom: 0.75rem;
    }
    
    .menu-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        margin-bottom: 0.5rem;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .menu-item.active {
        background-color: var(--primary);
        color: white;
    }
    
    .menu-item:hover:not(.active) {
        background-color: rgba(255, 255, 255, 0.1);
    }
    
    .menu-item i {
        margin-right: 0.75rem;
        width: 20px;
        text-align: center;
    }
    
    /* Main Content */
    .main-content {
        grid-column: 2;
        padding: 1.5rem 2rem;
    }
    
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    
    .header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--gray-900);
    }
    
    .header-actions {
        display: flex;
        gap: 1rem;
    }
    
    .header-actions .profile {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .profile-pic {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
    }
    
    /* Stats Cards */
    .stats-overview {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background-color: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .stat-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        border-radius: 12px;
        margin-bottom: 1rem;
        color: white;
    }
    
    .icon-blue {
        background-color: var(--primary);
    }
    
    .icon-green {
        background-color: var(--secondary);
    }
    
    .icon-yellow {
        background-color: var(--warning);
    }
    
    .icon-red {
        background-color: var(--danger);
    }
    
    .stat-card h3 {
        font-size: 0.875rem;
        color: var(--gray-600);
        margin-bottom: 0.5rem;
    }
    
    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .stat-change {
        display: flex;
        align-items: center;
        font-size: 0.875rem;
    }
    
    .stat-change.positive {
        color: var(--secondary);
    }
    
    .stat-change.negative {
        color: var(--danger);
    }
    
    /* Charts and Tables */
    .charts-section {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .chart-container {
        background-color: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .chart-header h2 {
        font-size: 1.25rem;
        font-weight: 600;
    }
    
    .chart-header select {
        padding: 0.5rem;
        border-radius: 0.375rem;
        border: 1px solid var(--gray-300);
        background-color: white;
        font-size: 0.875rem;
        outline: none;
    }
    
    .chart-wrapper {
        height: 300px;
    }
    
    /* Tables Section */
    .tables-section {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }
    
    .table-container {
        background-color: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .table-header h2 {
        font-size: 1.25rem;
        font-weight: 600;
    }
    
    .view-all {
        color: var(--primary);
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
    }
    
    .view-all:hover {
        text-decoration: underline;
    }
    
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .data-table th {
        text-align: left;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--gray-600);
        border-bottom: 1px solid var(--gray-200);
    }
    
    .data-table td {
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        border-bottom: 1px solid var(--gray-200);
    }
    
    .data-table tr:last-child td {
        border-bottom: none;
    }
    
    .status {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .status-completed {
        background-color: rgba(16, 185, 129, 0.1);
        color: var(--secondary);
    }
    
    .status-pending {
        background-color: rgba(245, 158, 11, 0.1);
        color: var(--warning);
    }
    
    .status-cancelled {
        background-color: rgba(239, 68, 68, 0.1);
        color: var(--danger);
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
        .stats-overview {
            grid-template-columns: repeat(2, 1fr);
        }
        .charts-section,
        .tables-section {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 768px) {
        .dashboard {
            grid-template-columns: 1fr;
        }
        .sidebar {
            display: none;
        }
        .main-content {
            grid-column: 1;
        }
    }
    
    @media (max-width: 640px) {
        .stats-overview {
            grid-template-columns: 1fr;
        }
    }
</style>

{{-- <div class="dashboard"> --}}
        <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1>Tableau de bord</h1>
        </div>
        
        <!-- Stats Overview -->
        <div class="stats-overview">
            <div class="stat-card">
                <div class="stat-icon icon-blue">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Élèves actifs</h3>
                <div class="stat-value">{{ $stats['users_count'] }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+8% cette semaine</span>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon icon-green">
                    <i class="fas fa-book"></i>
                </div>
                <h3>Cours</h3>
                <div class="stat-value">{{ $stats['courses_count'] }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+5% ce mois</span>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon icon-yellow">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h3>Examens</h3>
                <div class="stat-value">{{ $stats['exams_count'] }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+12% ce trimestre</span>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon icon-red">
                    <i class="fas fa-question-circle"></i>
                </div>
                <h3>Questions</h3>
                <div class="stat-value">{{ $stats['questions_count'] }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+15% ce mois</span>
                </div>
            </div>
        </div>
        
        <!-- Charts Section -->
        <div class="charts-section">
            <div class="chart-container">
                <div class="chart-header">
                    <h2>Progression des élèves</h2>
                    <select id="chartTimeframe">
                        <option value="week">Cette semaine</option>
                        <option value="month" selected>Ce mois</option>
                        <option value="quarter">Ce trimestre</option>
                        <option value="year">Cette année</option>
                    </select>
                </div>
                <div class="chart-wrapper">
                    <canvas id="studentProgressChart"></canvas>
                </div>
            </div>
            
            <div class="chart-container">
                <div class="chart-header">
                    <h2>Répartition des activités</h2>
                </div>
                <div class="chart-wrapper">
                    <canvas id="activitiesChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Tables Section -->
        <div class="tables-section">
            <div class="table-container">
                <div class="table-header">
                    <h2>Séries récentes</h2>
                    <a href="{{ route('monitor.series.index') }}" class="view-all">Voir tout</a>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Date de création</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stats['recent_series'] as $serie)
                        <tr>
                            <td>{{ $serie->title }}</td>
                            <td>{{ $serie->created_at->format('d/m/Y') }}</td>
                            <td>
                                <span class="status status-{{ $serie->status == 'active' ? 'completed' : 'pending' }}">
                                    {{ $serie->status == 'active' ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="table-container">
                <div class="table-header">
                    <h2>Cours récents</h2>
                    <a href="{{ route('monitor.courses.index') }}" class="view-all">Voir tout</a>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Date de création</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stats['recent_courses'] as $course)
                        <tr>
                            <td>{{ $course->title }}</td>
                            <td>{{ $course->created_at->format('d/m/Y') }}</td>
                            <td>
                                <span class="status status-{{ $course->status == 'active' ? 'completed' : 'pending' }}">
                                    {{ $course->status == 'active' ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
{{-- </div> --}}

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

<script>
    // Données pour les graphiques (à adapter avec des données dynamiques)
    document.addEventListener('DOMContentLoaded', function() {
        // Graphique de progression des élèves
        const studentProgressCtx = document.getElementById('studentProgressChart').getContext('2d');
        const studentProgressChart = new Chart(studentProgressCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
                datasets: [{
                    label: 'Taux de réussite',
                    data: [65, 68, 72, 75, 79, 85],
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(17, 24, 39, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: 'rgba(59, 130, 246, 0.5)',
                        borderWidth: 1,
                        padding: 12,
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                }
            }
        });
        
        // Graphique de répartition des activités
        const activitiesCtx = document.getElementById('activitiesChart').getContext('2d');
        const activitiesChart = new Chart(activitiesCtx, {
            type: 'doughnut',
            data: {
                labels: ['Conduite', 'Code', 'Examens', 'Administration'],
                datasets: [{
                    data: [65, 20, 10, 5],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ],
                    borderColor: 'white',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(17, 24, 39, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 12,
                        displayColors: false
                    }
                },
                cutout: '65%'
            }
        });
        
        // Gestion du changement de période pour le graphique
        document.getElementById('chartTimeframe').addEventListener('change', function() {
            // Ici, vous pourriez faire un appel AJAX pour charger les données selon la période sélectionnée
            // Pour l'exemple, nous changeons simplement les données aléatoirement
            const newData = Array.from({length: 6}, () => Math.floor(Math.random() * 30) + 55);
            studentProgressChart.data.datasets[0].data = newData;
            studentProgressChart.update();
        });
    });
</script>
@endsection