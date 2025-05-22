<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Question;
use App\Models\Serie;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Dashboard général (redirection selon le rôle)
    public function index()
    {
        if (Auth::user()->isMoniteur()) {
            return redirect()->route('monitor.dashboard');
        } else {
            return redirect()->route('eleve.dashboard');
        }
    }
    
    // Dashboard pour les moniteurs
    public function monitorDashboard()
    {
        $stats = [
            'series_count' => Serie::count(),
            'questions_count' => Question::count(),
            'courses_count' => Course::count(),
            'exams_count' => Exam::count(),
            'users_count' => User::where('role', 'eleve')->count(),
            'recent_series' => Serie::latest()->take(5)->get(),
            'recent_questions' => Question::latest()->take(5)->get(),
            'recent_courses' => Course::latest()->take(5)->get(),
        ];
        
        return view('monitor.dashboard', compact('stats'));
    }
    
    // Dashboard pour les élèves
    public function eleveDashboard()
    {
        $user = Auth::user();
        
        $stats = [
            'series_count' => Serie::where('is_active', true)->count(),
            'courses_count' => Course::where('active', true)->count(),
            'exams_available' => Exam::where('is_published', true)->count(),
            'exams_completed' => ExamAttempt::where('user_id', $user->id)
                ->where('status', 'completed')
                ->count(),
            'recent_courses' => Course::where('active', true)
                ->latest()
                ->take(3)
                ->get(),
            'recent_series' => Serie::where('is_active', true)
                ->latest()
                ->take(3)
                ->get(),
            'recent_attempts' => ExamAttempt::where('user_id', $user->id)
                ->with('exam')
                ->latest()
                ->take(5)
                ->get(),
        ];
        
        return view('eleve.dashboard', compact('stats'));
    }
}