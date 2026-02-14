<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            ['name' => 'Direktur', 'level' => 1],
            ['name' => 'SEVP', 'level' => 2],
            ['name' => 'VP', 'level' => 3],
            ['name' => 'AVP', 'level' => 4],
            ['name' => 'Officer', 'level' => 5],
        ];

        foreach ($positions as $position) {
            Position::create([
                'name' => $position['name'],
                'level' => $position['level'],
                'is_active' => true,
            ]);
        }        
    }
}
