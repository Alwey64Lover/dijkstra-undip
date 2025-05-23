<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function data(array $data): array
    {
        return array_merge($data, [
            'id' => @$data['id'] ?: strtolower(Str::ulid()),
            'created_at' => now()->toDateTimeString(),
            'updated_at' => now()->toDateTimeString(),
        ]);
    }

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(SettingSeeder::class);
        $this->call(RoomSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AcademicYearSeeder::class);
        $this->call(RealDataSeeders::class);
        $this->call(SchedulingSeeder::class);
        $this->call(AcademicSeeder::class);
    }
}
