<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['moniteur', 'eleve'])->default('eleve');
            $table->boolean('is_activited')->default(false);
            $table->timestamps();
        });
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
        User::insert([
            [
                'first_name' => 'Alpha',
                'last_name' => 'Root',
                'email' => 'moniteur@moniteur.moniteur',
                'password' => Hash::make('password123'),
                'role' => 'moniteur',
            ],
            [
                'first_name' => 'Eleve',
                'last_name' => 'Eleve',
                'email' => 'eleve@eleve.eleve',
                'password' => Hash::make('password123'),
                'role' => 'eleve',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
    }
};
