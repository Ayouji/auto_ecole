<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }
    public function registerForm()
    {
        return view('auth.register');
    }
    public function login(SignInRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return redirect()->back()->withErrors(['email' => 'Invalid email or password'])->withInput();
            }
            Auth::login($user);
            return redirect()->route('dashboard');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['message' => $th->getMessage()])->withInput();
        }
    }
    public function register(SignUpRequest $request)
    {
        try {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            return redirect()->route('login')
                ->with('success', 'Compte créé avec succès ! Veuillez vérifier votre email pour activer votre compte.');
        } catch (\Throwable $th) {
            return redirect()->back()
                ->withErrors(['message' => 'Une erreur est survenue lors de l\'inscription: ' . $th->getMessage()])
                ->withInput();
        }
    }
    public function logout(Request $request)
    {
        try {
            Auth::logout();
            return redirect()->route('login');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['message' => $th->getMessage()]);
        }
    }
    public function edit()
    {
        return view('components.profile.edit', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        try {
            $user = Auth::user();
            $validated = $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
                'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            ]);

            $user->fill([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
            ]);

            if ($validated['password'] ?? false) {
                $user->password = Hash::make($validated['password']);
            }

            $user->save();

            return redirect()->route('profile.edit')->with('success', 'Profil updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'An error occurred while updating the Profil.');
        }
    }
}
