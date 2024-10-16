<?php

namespace Database\Seeders;

use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Position::query()->exists()) {
            $admin = User::role('admin')->first();

            $data = [
                ['name' => 'CEO', 'admin_created_id' => $admin->id],
                ['name' => 'Manager', 'admin_created_id' => $admin->id],
                ['name' => 'HR', 'admin_created_id' => $admin->id],
                ['name' => 'Backend Developer', 'admin_created_id' => $admin->id],
                ['name' => 'Frontend Developer', 'admin_created_id' => $admin->id],
            ];

            foreach ($data as $position) {
                Position::query()->create($position);
            }
        }
    }
}
