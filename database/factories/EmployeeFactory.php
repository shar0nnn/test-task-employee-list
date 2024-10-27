<?php

namespace Database\Factories;

use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $admin = User::role('admin')->first();

        return [
            'full_name' => $this->faker->name(),
            'position_id' => Position::query()->pluck('id')->random(),
            'hired_at' => $this->faker->date(),
            'phone' => $this->faker->numerify('+380#########'),
            'email' => $this->faker->unique()->safeEmail(),
            'salary' => $this->faker->randomFloat(2, 10000, 500000),
            'rank' => 5,
            'admin_created_id' => $admin->id,
        ];
    }
}
