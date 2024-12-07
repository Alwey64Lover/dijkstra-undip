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
                    'schedules' => json_encode([]),
                ]),
                $this->data([
                    'name' => '2022/2023 Genap',
                    'is_active' => false,
                    'schedules' => json_encode([]),
                ]),
                $this->data([
                    'name' => '2023/2024 Ganjil',
                    'is_active' => false,
                    'schedules' => json_encode([]),
                ]),
                $this->data([
                    'name' => '2023/2024 Genap',
                    'is_active' => false,
                    'schedules' => json_encode([]),
                ]),
                $this->data([
                    'name' => '2024/2025 Ganjil',
                    'is_active' => false,
                    'schedules' => json_encode([]),
                ]),
                $this->data([
                    'name' => '2024/2025 Genap',
                    'is_active' => true,
                    'schedules' => json_encode([
                        'irs_filling_priority' => [
                            'start' => '2024-12-10 00:00:00',
                            'end' => '2024-12-11 00:00:00',
                        ],
                        'irs_filling_general' => [
                            'start' => '2024-12-12 00:00:00',
                            'end' => '2024-12-13 00:00:00',
                        ],
                        'irs_changes' => [
                            'start' => '2024-12-14 00:00:00',
                            'end' => '2024-12-15 00:00:00',
                        ],
                        'irs_cancellation' => [
                            'start' => '2024-12-16 00:00:00',
                            'end' => '2024-12-17 00:00:00',
                        ],
                    ])
                ]),
            ];

        // Insert
            AcademicYear::insert($academicYears);
    }
}
