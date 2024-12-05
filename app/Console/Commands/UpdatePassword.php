<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class UpdatePassword extends Command
{
    protected $signature = 'user:update-password {username} {password}';
    protected $description = 'Aggiorna la password di un utente';

    public function handle()
    {
        $username = $this->argument('username');
        $password = bcrypt($this->argument('password'));

        $user = User::where('username', $username)->first();

        if (!$user) {
            $this->error("Utente {$username} non trovato.");
            return;
        }

        $user->password = $password;
        $user->save();

        $this->info("Password aggiornata con successo per {$username}.");
    }
}

