<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!User::query()->exists()){
            $foo = User::factory()->create([
                'name' => 'Bob',
                'email' => 'bob@gmail.com',
                'password' => Hash::make('bob123'),
            ]);

            $bar = User::factory()->create([
                'name' => 'John',
                'email' => 'john@gmail.com',
                'password' => Hash::make('john123'),
            ]);

            $roleAdmin = Role::query()->where('name', 'admin')->first();

            $foo->assignRole($roleAdmin);
            $bar->assignRole($roleAdmin);
        }
    }
}
