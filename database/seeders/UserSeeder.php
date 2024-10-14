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
        $foo = User::factory()->create([
            'name' => 'Foo',
            'email' => 'foo@gmail.com',
            'password' => Hash::make('foo123'),
        ]);

        $bar = User::factory()->create([
            'name' => 'Bar',
            'email' => 'bar@gmail.com',
            'password' => Hash::make('bar123'),
        ]);

        $roleAdmin = Role::query()->where('name', 'admin')->first();

        $foo->assignRole($roleAdmin);
        $bar->assignRole($roleAdmin);
    }
}
