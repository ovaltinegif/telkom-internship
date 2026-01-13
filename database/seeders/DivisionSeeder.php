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
            ['name' => 'HC & Finance', 'code' => 'HCF'],
            ['name' => 'Access & Service Operation', 'code' => 'ASO'],
            ['name' => 'Sales & Customer Care', 'code' => 'SCC'],
            ['name' => 'Digital Service & Wifi', 'code' => 'DSW'],
            ['name' => 'Government Service', 'code' => 'DGS'],
        ];

        foreach ($divisions as $division) {
            Division::create($division);
        }
    }
}
