<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure role exists
        Role::firstOrCreate(['name' => 'super_admin']);

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@morfiqo.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'), // password is 'password'
            ]
        );

        // Assign role
        $admin->assignRole('super_admin');
    }
}
