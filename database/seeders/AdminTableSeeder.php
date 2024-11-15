<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserTypes;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();

        $admin = new User;
        $admin->username = 'admin';
        $admin->email = 'admin@admin.com';
        $admin->password = bcrypt('12345678'); 
        $admin->role_id = $adminRole->id; // Set a secure password
        $admin->status = 0; // Set a secure password
        $admin->first_name = 'User';
        $admin->last_name = 'User';

        // Set a secure password
        $admin->save();
        $admin->assignRole($adminRole);
    }
}
