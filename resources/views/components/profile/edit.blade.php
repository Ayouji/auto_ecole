@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card profile-card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <!-- Sidebar avec informations utilisateur -->
                            <div class="col-lg-3 profile-sidebar">
                                <div class="profile-header text-center py-5">
                                    <div class="avatar-wrapper mb-4">
                                        <div class="user-avatar">
                                            <span>{{ substr(Auth::user()->first_name, 0, 1) . substr(Auth::user()->last_name, 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <h4 class="user-name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h4>
                                    <span class="user-role">{{ Auth::user()->role ?? 'Utilisateur' }}</span>
                                </div>

                                <div class="profile-menu">
                                    <div class="nav flex-column">
                                        <a href="#personal-info" class="profile-menu-item active" data-bs-toggle="pill">
                                            <i class="bi bi-person-vcard"></i>
                                            Informations personnelles
                                        </a>
                                    </div>
                                </div>


                            </div>

                            <!-- Contenu principal -->
                            <div class="col-lg-9 profile-content">
                                <div class="content-header d-flex justify-content-between align-items-center px-4 py-3">
                                    <h5 class="mb-0">
                                        <i class="bi bi-person-gear me-2"></i>
                                        Paramètres du profil
                                    </h5>
                                </div>

                                <div class="tab-content p-4">
                                    <!-- Informations personnelles -->
                                    <div class="tab-pane fade show active" id="personal-info">
                                        <form method="POST" action="{{ route('profile.update') }}" class="profile-form">
                                            @csrf
                                            @method('patch')

                                            <div class="row mb-4">
                                                <div class="col-md-6 mb-3">
                                                    <label for="first_name" class="form-label">Prénom</label>
                                                    <div class="input-group input-group-custom">
                                                        <span class="input-group-text">
                                                            <i class="bi bi-person"></i>
                                                        </span>
                                                        <input id="first_name" type="text"
                                                            class="form-control @error('first_name') is-invalid @enderror"
                                                            name="first_name"
                                                            value="{{ old('first_name', $user->first_name) }}" 
                                                            autocomplete="first_name">
                                                    </div>
                                                    @error('first_name')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="last_name" class="form-label">Nom</label>
                                                    <div class="input-group input-group-custom">
                                                        <span class="input-group-text">
                                                            <i class="bi bi-person-fill"></i>
                                                        </span>
                                                        <input id="last_name" type="text"
                                                            class="form-control @error('last_name') is-invalid @enderror"
                                                            name="last_name"
                                                            value="{{ old('last_name', $user->last_name) }}" 
                                                            autocomplete="last_name">
                                                    </div>
                                                    @error('last_name')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <label for="email" class="form-label">Adresse e-mail</label>
                                                <div class="input-group input-group-custom">
                                                    <span class="input-group-text">
                                                        <i class="bi bi-envelope"></i>
                                                    </span>
                                                    <input id="email" type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        name="email" value="{{ old('email', $user->email) }}" 
                                                        autocomplete="email">
                                                </div>
                                                @error('email')
                                                    <div class="form-text text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="divider my-4">
                                                <span>Modifier le mot de passe</span>
                                            </div>

                                            <div class="row mb-4">
                                                <div class="col-md-6 mb-3">
                                                    <label for="password" class="form-label">Nouveau mot de passe</label>
                                                    <div class="input-group input-group-custom">
                                                        <span class="input-group-text">
                                                            <i class="bi bi-lock"></i>
                                                        </span>
                                                        <input id="password" type="password"
                                                            class="form-control @error('password') is-invalid @enderror"
                                                            name="password" autocomplete="new-password"
                                                            placeholder="Laisser vide pour ne pas changer">
                                                    </div>
                                                    @error('password')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="password-confirm" class="form-label">Confirmer le mot de
                                                        passe</label>
                                                    <div class="input-group input-group-custom">
                                                        <span class="input-group-text">
                                                            <i class="bi bi-lock-fill"></i>
                                                        </span>
                                                        <input id="password-confirm" type="password" class="form-control"
                                                            name="password_confirmation" autocomplete="new-password">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-end mt-5">
                                                <button type="submit" class="btn btn-primary btn-save">
                                                    <i class="bi bi-check2 me-2"></i>Enregistrer les modifications
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Styles généraux */
        .profile-card {
            border-radius: 12px;
            overflow: hidden;
        }

        .form-label {
            font-weight: 500;
            color: #1e4e8c;
            margin-bottom: 0.5rem;
        }

        /* Sidebar du profil */
        .profile-sidebar {
            background-color: #f8f9fa;
            border-right: 1px solid rgba(0, 50, 100, 0.1);
            min-height: 100%;
        }

        .user-avatar {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #1e4e8c 0%, #2c73d2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 42px;
            box-shadow: 0 4px 15px rgba(44, 115, 210, 0.25);
            margin: auto;
        }

        .user-name {
            color: #1e4e8c;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .user-role {
            background-color: #1e4e8c;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .profile-menu {
            padding: 0 1rem;
        }

        .profile-menu-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: #495057;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: all 0.2s ease;
        }

        .profile-menu-item i {
            margin-right: 12px;
            font-size: 18px;
            color: #1e4e8c;
        }

        .profile-menu-item.active,
        .profile-menu-item:hover {
            background-color: rgba(30, 78, 140, 0.1);
            color: #1e4e8c;
        }

        .status-badge {
            background-color: #e6f4ea;
            color: #28a745;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }

        /* Contenu principal */
        .content-header {
            border-bottom: 1px solid rgba(0, 50, 100, 0.1);
            color: #1e4e8c;
        }

        .success-toast {
            border-radius: 20px;
            font-size: 14px;
            border: none;
            background-color: #d1e7dd;
            color: #0f5132;
        }

        /* Formulaire */
        .input-group-custom {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .input-group-text {
            background-color: #f8f9fa;
            border: none;
            color: #1e4e8c;
        }

        .form-control {
            border: none;
            border-left: 1px solid rgba(0, 50, 100, 0.1);
            padding-left: 15px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: rgba(30, 78, 140, 0.5);
        }

        .divider {
            position: relative;
            text-align: center;
            height: 20px;
            border-bottom: 1px solid rgba(0, 50, 100, 0.1);
            margin: 30px 0;
        }

        .divider span {
            background-color: white;
            padding: 0 15px;
            position: relative;
            top: 10px;
            color: #6c757d;
            font-size: 14px;
        }

        .btn-save {
            padding: 10px 20px;
            background: linear-gradient(135deg, #1e4e8c 0%, #2c73d2 100%);
            border: none;
            border-radius: 8px;
            font-weight: 500;
            box-shadow: 0 4px 10px rgba(44, 115, 210, 0.25);
            transition: all 0.3s ease;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(44, 115, 210, 0.35);
        }

        /* Tables et éléments des autres onglets */
        .section-title {
            color: #1e4e8c;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(0, 50, 100, 0.1);
        }

        .security-table {
            font-size: 14px;
        }

        .security-table th {
            font-weight: 600;
            color: #1e4e8c;
        }

        .preference-item {
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        .form-check-input:checked {
            background-color: #1e4e8c;
            border-color: #1e4e8c;
        }

        @media (max-width: 991px) {
            .profile-sidebar {
                border-right: none;
                border-bottom: 1px solid rgba(0, 50, 100, 0.1);
            }
        }
    </style>
@endsection
