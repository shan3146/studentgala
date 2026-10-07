<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class MasterAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'qmrzeeshan@gmail.com',
            ],
            [
                'name' => 'Master Admin',
                'role' => 'master_admin',
            ]
        );
    }
}