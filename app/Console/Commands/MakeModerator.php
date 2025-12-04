<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;

class MakeModerator extends Command
{
    protected $signature = 'user:make-moderator {email}';
    protected $description = 'Назначить роль модератора пользователю по email';

    public function handle(): int
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();
        if (!$user) {
            $this->error("Пользователь с email {$email} не найден");
            return Command::FAILURE;
        }

        $role = Role::where('name', 'moderator')->first();
        if (!$role) {
            $this->error('Роль moderator не найдена. Убедитесь, что сидер ролей выполнен.');
            return Command::FAILURE;
        }

        $user->roles()->syncWithoutDetaching([$role->id]);
        $this->info("Пользователю {$email} назначена роль moderator");
        return Command::SUCCESS;
    }
}
