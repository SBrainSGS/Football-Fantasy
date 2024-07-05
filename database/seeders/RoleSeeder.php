<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        Role::create(['name' => 'user', 'guard_name' => 'web']);
        User::create(['id' => '1', 'login' => 'admin', 'password' => Hash::make('admin'), 'rating' => '0']);

        $user = User::find(1);
        $user->assignRole('admin');
    }
}
