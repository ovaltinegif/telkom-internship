<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Division;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisions = [
            ['name' => 'Shared Service and General Support', 'code' => 'SSGS'],
            ['name' => 'Business Service', 'code' => 'BS'],
            ['name' => 'Government Service', 'code' => 'GS'],
            ['name' => 'Performance, Risk, and Quality of Sales', 'code' => 'PRQS'],
        ];

        foreach ($divisions as $division) {
            Division::create($division);
        }
    }
}
