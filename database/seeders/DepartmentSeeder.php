<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends DatabaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $headOfDepartment = User::where('role', 'head_of_department')->first();

        // Departments
            $departments = [
                $this->data([
                    'name' => 'Informatika',
                    'user_id' => $headOfDepartment->id,
                ]),
                $this->data([
                    'name' => 'Biologi',
                    'user_id' => null,
                ]),
                $this->data([
                    'name' => 'Matematika',
                    'user_id' => null,
                ]),
                $this->data([
                    'name' => 'Fisika',
                    'user_id' => null,
                ]),
                $this->data([
                    'name' => 'Kimia',
                    'user_id' => null,
                ]),
                $this->data([
                    'name' => 'Statistika',
                    'user_id' => null,
                ]),
            ];

        // Insert
            Department::insert($departments);
    }
}
