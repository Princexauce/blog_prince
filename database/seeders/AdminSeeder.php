<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Admin::where('email', 'admin@blog.com')->delete();

        Admin::updateOrCreate(
            ['email' => 'adminblog@gmail.com'],
            ['password' => Hash::make('password')]
        );
    }
}
