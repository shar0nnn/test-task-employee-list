<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            PositionSeeder::class,
        ]);

        Employee::factory()->count(10)->create();

        Employee::factory()->count(20)->create([
            'manager_id' => function() {
                return Employee::query()->where('rank', 5)->pluck('id')->random();
            },
            'rank' => 4,
        ]);

        Employee::factory()->count(50)->create([
            'manager_id' => function() {
                return Employee::query()->where('rank', 4)->pluck('id')->random();
            },
            'rank' => 3,
        ]);

        Employee::factory()->count(100)->create([
            'manager_id' => function() {
                return Employee::query()->where('rank', 3)->pluck('id')->random();
            },
            'rank' => 2,
        ]);

        Employee::factory()->count(200)->create([
            'manager_id' => function() {
                return Employee::query()->where('rank', 2)->pluck('id')->random();
            },
            'rank' => 1,
        ]);
    }
}
