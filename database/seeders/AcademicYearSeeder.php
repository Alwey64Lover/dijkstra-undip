<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicYearSeeder extends DatabaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Academic Years
            $academicYears = [
                $this->data([
                    'name' => '2022/2023 Ganjil',
                    'is_active' => false,
                ]),
                $this->data([
                    'name' => '2022/2023 Genap',
                    'is_active' => false,
                ]),
                $this->data([
                    'name' => '2023/2024 Ganjil',
                    'is_active' => false,
                ]),
                $this->data([
                    'name' => '2023/2024 Genap',
                    'is_active' => false,
                ]),
                $this->data([
                    'name' => '2024/2025 Ganjil',
                    'is_active' => true,
                ]),
                $this->data([
                    'name' => '2024/2025 Genap',
                    'is_active' => false,
                ]),
            ];

        // Insert
            AcademicYear::insert($academicYears);
    }
}
