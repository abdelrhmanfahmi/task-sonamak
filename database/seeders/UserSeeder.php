<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => '12345678',
        ]);

        $admin->assignRole('admin');

        $viewer = User::create([
            'name' => 'viewer',
            'email' => 'viewer@viewer.com',
            'password' => '12345678',
        ]);

        $viewer->assignRole('viewer');

        $editor = User::create([
            'name' => 'editor',
            'email' => 'editor@editor.com',
            'password' => '12345678',
        ]);

        $editor->assignRole('editor');
    }
}
