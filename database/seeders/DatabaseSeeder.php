<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;


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

        $faker = Faker::create();
        $admin = User::role('admin')->first();
        $positions = Position::query()->pluck('id');
        $countEmployees = [100, 1000, 5000, 15000, 30000];

        for ($i = 0; $i < 5; $i++) {
            $managers = Employee::where('rank', 6 - $i)->pluck('id');
            $rank = 5 - $i;
            $employees = [];

            for ($j = 0; $j < $countEmployees[$i]; $j++) {
                $employees[] = [
                    'manager_id' => $rank === 5 ? null : $managers->random(),
                    'rank' => $rank,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'full_name' => $faker->name(),
                    'position_id' => $positions->random(),
                    'hired_at' => $faker->date(),
                    'phone' => $faker->numerify('+380#########'),
                    'email' => $faker->unique()->safeEmail(),
                    'salary' => $faker->randomFloat(2, 10000, 500000),
                    'admin_created_id' => $admin->id,
                ];
            }

            foreach (array_chunk($employees, 1000) as $chunk) {
                Employee::insert($chunk);
            }
        }
    }
}
