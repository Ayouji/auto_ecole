 @extends('layouts.app')

 @section('content')
     <div class="contenair">
         <div class="main">
             <div class="welcome-banner">
                 <i class="fas fa-hand-sparkles welcome-icon"></i>
                 <div class="welcome-text">
                     <h2>Bonjour {{ Auth::check() ? Auth::user()->first_name . ' ' . Auth::user()->last_name : 'Invité' }}
                         👋</h2>
                     <p>Voici ce qui se passe sur votre tableau de bord aujourd’hui.</p>
                 </div>
             </div>


             <div class="cards-container">
                 <div class="stat-card">
                     <div class="card-icon bg-blue">
                         <i class="fas fa-brain"></i>
                     </div>
                     <div class="card-content">
                         <h3>Total Clients</h3>
                         <p></p>
                     </div>
                 </div>

                 <div class="stat-card">
                     <div class="card-icon bg-green">
                         <i class="fas fa-comment-medical"></i>
                     </div>
                     <div class="card-content">
                         <h3>Total Responses</h3>
                         <p></p>
                     </div>
                 </div>

                 <div class="stat-card">
                     <div class="card-icon bg-orange">
                         <i class="fas fa-hourglass-half"></i>
                     </div>
                     <div class="card-content">
                         <h3>Collaborators Involved</h3>
                         <p></p>
                     </div>
                 </div>

                 <div class="stat-card">
                     <div class="card-icon bg-purple">
                         <i class="fas fa-chart-line"></i>
                     </div>
                     <div class="card-content">
                         <h3>Average Progress</h3>
                         <p>%</p>
                     </div>
                 </div>
             </div>

             <div class="dashboard-row">
                 <div class="chart-container">
                     <div class="chart-header">
                         <h3>Response Activity</h3>
                     </div>
                     <canvas id="moodChart"></canvas>
                 </div>

                 <div class="chart-container">
                     <div class="chart-header">
                         <h3>Responses per Category</h3>
                     </div>
                     <canvas id="feedbackChart"></canvas>
                 </div>

             </div>
         </div>
     </div>
     <style>
         @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');

         :root {
             --primary: #5D5FEF;
             --secondary: #6C757D;
             --success: #28A745;
             --danger: #DC3545;
             --warning: #FFC107;
             --info: #17A2B8;
             --light: #F8F9FA;
             --dark: #343A40;
         }

         .main {
             padding-left: 24px;
             padding-right: 24px;
             font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
         }

         .cards-container {
             display: flex;
             gap: 15px;
             flex-wrap: wrap;
             margin-bottom: 24px;
         }

         .stat-card {
             flex: 1;
             min-width: 180px;
             background: white;
             border-radius: 8px;
             box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
             padding: 15px;
             display: flex;
             align-items: center;
             transition: transform 0.3s ease;
         }

         .welcome-banner {
             padding: 20px 30px;
             border-radius: 12px;
             display: flex;
             align-items: center;
             gap: 20px;
         }

         .welcome-icon {
             font-size: 36px;
             color: var(--primary);
             animation: wave 1.5s infinite;
         }

         .welcome-text h2 {
             margin: 0;
             font-size: 22px;
             color: #333;
         }

         .welcome-text p {
             margin: 5px 0 0;
             font-size: 15px;
             color: #666;
         }

         @keyframes wave {
             0% {
                 transform: rotate(0deg);
             }

             20% {
                 transform: rotate(14deg);
             }

             40% {
                 transform: rotate(-8deg);
             }

             60% {
                 transform: rotate(14deg);
             }

             80% {
                 transform: rotate(-4deg);
             }

             100% {
                 transform: rotate(0deg);
             }
         }



         .card-icon {
             width: 50px;
             height: 50px;
             border-radius: 50%;
             display: flex;
             align-items: center;
             justify-content: center;
             margin-right: 15px;
             color: white;
             font-size: 20px;
         }

         .bg-blue {
             background: #4285F4;
         }

         .bg-green {
             background: #34A853;
         }

         .bg-orange {
             background: #FBBC05;
         }

         .bg-purple {
             background: #9B59B6;
         }

         .card-content h3 {
             margin: 0;
             color: #555;
             font-size: 14px;
             font-weight: 600;
         }

         .card-content p {
             margin: 8px 0;
             font-size: 24px;
             font-weight: 700;
             color: #2c3e50;
         }

         .trend {
             font-size: 10px;
             font-weight: 500;
         }

         .trend.up {
             color: #2ecc71;
         }

         .trend.down {
             color: #e74c3c;
         }

         .dashboard-row {
             display: flex;
             gap: 15px;
             margin-bottom: 24px;
         }

         .chart-container {
             flex: 1;
             background: white;
             border-radius: 8px;
             box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
             padding: 15px;
         }

         .chart-container.wide {
             flex: 2;
         }

         .chart-header {
             display: flex;
             justify-content: space-between;
             align-items: center;
             margin-bottom: 15px;
         }

         .chart-header h3 {
             margin: 0;
             color: #2c3e50;
             font-size: 16px;
         }

         .time-filter {
             padding: 5px 10px;
             border-radius: 4px;
             border: 1px solid #ddd;
             font-size: 12px;
         }
     </style>
 @endsection
