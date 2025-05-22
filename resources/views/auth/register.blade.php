<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Code de la Route</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        :root {
            --primary: #e63946;
            /* Rouge pour le code de la route */
            --primary-dark: #c1121f;
            --primary-light: #fff1f1;
            --secondary: #023e8a;
            /* Bleu foncé pour contraste */
            --accent: #ffb703;
            /* Jaune pour les éléments d'attention */
            --text-dark: #333333;
            --text-muted: #6c757d;
            --border-color: #e0e0e0;
            --error: #d90429;
            --success: #06d6a0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background-color: #f8f9fa;
            background-image:
                radial-gradient(at 80% 20%, rgba(230, 57, 70, 0.05) 0px, transparent 50%),
                radial-gradient(at 20% 80%, rgba(2, 62, 138, 0.08) 0px, transparent 50%),
                linear-gradient(135deg, rgba(255, 255, 255, 0.913) 0%, rgba(250, 250, 250, 0.986) 100%);
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-container {
            width: 100%;
            max-width: 600px;
        }

        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
            background-color: #ffffff;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: "";
            position: absolute;
            top: -100px;
            right: -100px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background-color: rgba(230, 57, 70, 0.05);
            z-index: 0;
        }

        .card::after {
            content: "";
            position: absolute;
            bottom: -50px;
            left: -50px;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-color: rgba(2, 62, 138, 0.03);
            z-index: 0;
        }

        .logo-container {
            margin-bottom: 1.5rem;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .access-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.05);
                opacity: 0.8;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .header-text {
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
            z-index: 1;
        }

        .title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .subtitle {
            font-size: 0.95rem;
            color: var(--text-muted);
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 1;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            border: 1.5px solid var(--border-color);
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(230, 57, 70, 0.15);
        }

        .is-invalid {
            border-color: var(--error);
        }

        .is-invalid:focus {
            border-color: var(--error);
            box-shadow: 0 0 0 0.25rem rgba(217, 4, 41, 0.15);
        }

        .invalid-feedback {
            color: var(--error);
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        .input-group {
            position: relative;
        }

        .input-group-text {
            background-color: transparent;
            border-right: none;
            border-top-left-radius: 0.75rem;
            border-bottom-left-radius: 0.75rem;
        }

        .with-icon {
            border-left: none;
            padding-left: 0.5rem;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 1rem;
        }

        .terms-text {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 1.5rem;
        }

        .terms-text a {
            color: var(--secondary);
            text-decoration: none;
            font-weight: 600;
        }

        .terms-text a:hover {
            text-decoration: underline;
        }

        .form-check {
            margin-bottom: 1.5rem;
        }

        .form-check-input {
            width: 1.1em;
            height: 1.1em;
            margin-top: 0.25em;
            border-color: var(--border-color);
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .form-check-label {
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            border-radius: 0.75rem;
            font-weight: 600;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(230, 57, 70, 0.25);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(230, 57, 70, 0.35);
        }

        .btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(230, 57, 70, 0.25);
        }

        .info-box {
            background-color: #e7f5ff;
            border-left: 4px solid var(--secondary);
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
            color: var(--secondary);
            display: flex;
            align-items: center;
        }

        .info-box i {
            margin-right: 0.5rem;
            font-size: 1rem;
        }

        .login-text {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .login-text a {
            color: var(--secondary);
            text-decoration: none;
            font-weight: 600;
        }

        .login-text a:hover {
            text-decoration: underline;
        }

        .loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid rgba(230, 57, 70, 0.2);
            border-radius: 50%;
            border-top-color: var(--primary);
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .row {
            --bs-gutter-x: 1rem;
        }

        @media (max-width: 576px) {
            .card {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="loader" id="load_screen">
        <div class="spinner"></div>
    </div>

    <div class="register-container">
        <div class="card">
            <div class="logo-container">
                <i class="fa-solid fa-car access-icon"></i>
            </div>

            <div class="header-text">
                <h1 class="title">Créer un compte</h1>
                <p class="subtitle">Rejoignez notre communauté et commencez votre apprentissage du code de la route</p>
            </div>

            <form action="{{route('auth.register')}}" method="post">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="first_name" class="form-label">Prénom</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                                <input type="text"
                                    class="form-control with-icon @error('first_name') is-invalid @enderror"
                                    id="first_name" name="first_name" placeholder="Votre prénom"
                                    value="{{ old('first_name') }}">
                            </div>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last_name" class="form-label">Nom</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                                <input type="text"
                                    class="form-control with-icon @error('last_name') is-invalid @enderror"
                                    id="last_name" name="last_name" placeholder="Votre nom"
                                    value="{{ old('last_name') }}">
                            </div>
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Adresse email</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fa-regular fa-envelope"></i>
                        </span>
                        <input type="email" class="form-control with-icon @error('email') is-invalid @enderror"
                            id="email" name="email" placeholder="Votre adresse email" value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" class="form-control with-icon @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="Créez un mot de passe sécurisé">
                        <button type="button" class="toggle-password" aria-label="Afficher/Masquer le mot de passe">
                            <i class="fa-regular fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-check">
                    <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" id="terms"
                        name="terms">
                    <label class="form-check-label" for="terms">
                        J'accepte les <a href="#">conditions d'utilisation</a> et la <a href="#">politique
                            de confidentialité</a>
                    </label>
                    @error('terms')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="info-box">
                    <i class="fa-solid fa-circle-info"></i>
                    <div>Après votre inscription, vous recevrez un email de confirmation pour activer votre compte.
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="fa-solid fa-user-plus me-2"></i>Créer mon compte
                </button>

                <div class="login-text">
                    Vous avez déjà un compte ? <a href="{{ route('login') }}">Connectez-vous</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Hide loader after page loads
        window.addEventListener('load', function() {
            const loader = document.getElementById('load_screen');
            setTimeout(function() {
                loader.style.display = 'none';
            }, 500);
        });

        // Toggle password visibility for password field
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.querySelector('.toggle-password');
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            toggleButton.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    toggleIcon.classList.remove('fa-eye');
                    toggleIcon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    toggleIcon.classList.remove('fa-eye-slash');
                    toggleIcon.classList.add('fa-eye');
                }
            });

            // Toggle password visibility for confirmation field
            const toggleButtonConfirm = document.querySelector('.toggle-password-confirm');
            const passwordConfirmInput = document.getElementById('password_confirmation');
            const toggleIconConfirm = document.getElementById('toggleIconConfirm');

            toggleButtonConfirm.addEventListener('click', function() {
                if (passwordConfirmInput.type === 'password') {
                    passwordConfirmInput.type = 'text';
                    toggleIconConfirm.classList.remove('fa-eye');
                    toggleIconConfirm.classList.add('fa-eye-slash');
                } else {
                    passwordConfirmInput.type = 'password';
                    toggleIconConfirm.classList.remove('fa-eye-slash');
                    toggleIconConfirm.classList.add('fa-eye');
                }
            });
        });
    </script>
</body>
</html>
