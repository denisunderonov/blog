<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Role::create([
            'name' => 'moderator',
            'display_name' => 'Модератор',
            'description' => 'Полный доступ ко всем статьям и комментариям'
        ]);

        \App\Models\Role::create([
            'name' => 'reader',
            'display_name' => 'Читатель',
            'description' => 'Может только просматривать статьи и добавлять комментарии'
        ]);
    }
}
