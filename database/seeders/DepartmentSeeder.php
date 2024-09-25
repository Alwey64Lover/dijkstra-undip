<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends DatabaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Departments
            $departments = [
                $this->data([
                    'name' => 'Informatika',
                ]),
                $this->data([
                    'name' => 'Biologi',
                ]),
                $this->data([
                    'name' => 'Matematika',
                ]),
                $this->data([
                    'name' => 'Fisika',
                ]),
                $this->data([
                    'name' => 'Kimia',
                ]),
                $this->data([
                    'name' => 'Statistika',
                ]),
            ];

        // Insert
            Department::insert($departments);
    }
}
