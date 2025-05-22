<?php

use App\Http\Controllers\Monitor\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Eleve\SerieController as EleveSerieController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SerieController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\Monitor\SerieController as MonitorSerieController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

// Routes publiques
Route::get('/login', [UserController::class, 'loginForm'])->name('login');
Route::get('/register', [UserController::class, 'registerForm'])->name('register');
Route::post('/auth/login', [UserController::class, 'login'])->name('auth.login');
Route::post('/auth/register', [UserController::class, 'register'])->name('auth.register');

// Routes protégées par authentification
Route::middleware(AuthMiddleware::class)->group(function () {
    // Dashboard commun
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profil utilisateur
    Route::get('/profile', [UserController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [UserController::class, 'update'])->name('profile.update');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    
    // ESPACE MONITEUR
    Route::prefix('monitor')->name('monitor.')->middleware([RoleMiddleware::class.':moniteur'])->group(function () {
        // Dashboard moniteur
        Route::get('/', [DashboardController::class, 'monitorDashboard'])->name('dashboard');
        
        // Gestion des séries
        Route::resource('series', MonitorSerieController::class);
        
        // Gestion des questions
        Route::resource('questions', QuestionController::class);
        Route::post('questions/{question}/toggle-status', [QuestionController::class, 'toggleStatus'])->name('questions.toggle-status');
        Route::post('questions/{question}/upload-audio', [QuestionController::class, 'uploadAudio'])->name('questions.upload-audio');
        Route::post('questions/store-audio', [QuestionController::class, 'storeAudio'])->name('questions.store.audio');
        
        // Gestion des cours
        Route::resource('courses', CourseController::class);
        Route::post('upload/image', [CourseController::class, 'uploadImage'])->name('upload.image');
        // Gestion des examens blancs
        Route::resource('exams', ExamController::class);
        Route::post('exams/{exam}/add-question', [ExamController::class, 'addQuestion'])->name('exams.add-question');
        Route::delete('exams/{exam}/remove-question/{question}', [ExamController::class, 'removeQuestion'])->name('exams.remove-question');
        Route::post('exams/{exam}/publish', [ExamController::class, 'publish'])->name('exams.publish');
        
        // Gestion des utilisateurs (élèves)
        Route::resource('users', UserController::class);
    });
    
    // ESPACE ÉLÈVE
    Route::prefix('eleve')->name('eleve.')->middleware([RoleMiddleware::class.':eleve'])->group(function () {
        // Dashboard élève
        Route::get('/', [DashboardController::class, 'eleveDashboard'])->name('dashboard');
        
        // Consultation des séries
        Route::get('series', [EleveSerieController::class, 'index'])->name('series.index');
        Route::get('series/{serie}', [EleveSerieController::class, 'show'])->name('series.show');
        
        // Consultation des cours
        Route::get('courses', [EleveController::class, 'courses'])->name('courses.index');
        Route::get('courses/{slug}', [EleveController::class, 'showCourse'])->name('courses.show');
        
        // Consultation des questions
        Route::get('questions', [EleveController::class, 'questions'])->name('questions.index');
        Route::get('questions/{question}', [EleveController::class, 'showQuestion'])->name('questions.show');
        
        // Examens blancs
        Route::get('exams', [EleveController::class, 'exams'])->name('exams.index');
        Route::get('exams/{exam}', [EleveController::class, 'showExam'])->name('exams.show');
        Route::post('exams/{exam}/start', [EleveController::class, 'startExam'])->name('exams.start');
        Route::post('exams/{exam}/submit', [EleveController::class, 'submitExam'])->name('exams.submit');
        Route::get('exam-results/{attempt}', [EleveController::class, 'examResults'])->name('exams.results');
    });
});

// Route pour l'upload d'images dans l'éditeur de texte
Route::post('/courses/upload-image', [CourseController::class, 'uploadImage'])->name('courses.upload.image');

// ESPACE MONITEUR
Route::prefix('monitor')->name('monitor.')->middleware([RoleMiddleware::class.':moniteur'])->group(function () {
    // Dashboard moniteur
    Route::get('/', [DashboardController::class, 'monitorDashboard'])->name('dashboard');
    
    // Gestion des séries
    Route::resource('series', MonitorSerieController::class);
    
    // Gestion des questions
    Route::resource('questions', QuestionController::class);
    Route::post('questions/{question}/toggle-status', [QuestionController::class, 'toggleStatus'])->name('questions.toggle-status');
    Route::post('questions/{question}/upload-audio', [QuestionController::class, 'uploadAudio'])->name('questions.upload-audio');
    Route::post('questions/store-audio', [QuestionController::class, 'storeAudio'])->name('questions.store.audio');
    
    // Gestion des cours
    Route::resource('courses', CourseController::class);
    Route::post('upload/image', [App\Http\Controllers\Monitor\CourseController::class, 'uploadImage'])->name('upload.image');
    // Gestion des examens blancs
    Route::resource('exams', ExamController::class);
    Route::post('exams/{exam}/add-question', [ExamController::class, 'addQuestion'])->name('exams.add-question');
    Route::delete('exams/{exam}/remove-question/{question}', [ExamController::class, 'removeQuestion'])->name('exams.remove-question');
    Route::post('exams/{exam}/publish', [ExamController::class, 'publish'])->name('exams.publish');
    
    // Gestion des utilisateurs (élèves)
    Route::resource('users', UserController::class);
});

// ESPACE ÉLÈVE
Route::prefix('eleve')->name('eleve.')->middleware([RoleMiddleware::class.':eleve'])->group(function () {
    // Dashboard élève
    Route::get('/', [DashboardController::class, 'eleveDashboard'])->name('dashboard');
    
    // Consultation des séries
    Route::get('series', [Eleve\SerieController::class, 'index'])->name('series.index');
    Route::get('series/{serie}', [Eleve\SerieController::class, 'show'])->name('series.show');
    
    // Consultation des cours
    Route::get('courses', [EleveController::class, 'courses'])->name('courses.index');
    Route::get('courses/{slug}', [EleveController::class, 'showCourse'])->name('courses.show');
    
    // Consultation des questions
    Route::get('questions', [EleveController::class, 'questions'])->name('questions.index');
    Route::get('questions/{question}', [EleveController::class, 'showQuestion'])->name('questions.show');
    
    // Examens blancs
    Route::get('exams', [EleveController::class, 'exams'])->name('exams.index');
    Route::get('exams/{exam}', [EleveController::class, 'showExam'])->name('exams.show');
    Route::post('exams/{exam}/start', [EleveController::class, 'startExam'])->name('exams.start');
    Route::post('exams/{exam}/submit', [EleveController::class, 'submitExam'])->name('exams.submit');
    Route::get('exam-results/{attempt}', [EleveController::class, 'examResults'])->name('exams.results');
});

// Route pour l'upload d'images dans l'éditeur de texte
Route::post('/courses/upload-image', [CourseController::class, 'uploadImage'])->name('courses.upload.image');
