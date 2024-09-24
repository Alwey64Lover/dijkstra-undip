<?php

namespace Database\Seeders;

use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends DatabaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            $this->data([
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'superadmin',
            ]),
            $this->data([
                'name' => 'Clement Ponso',
                'email' => 'clementponso@deans.undip.ac.id',
                'password' => bcrypt('password'),
                'role' => 'dean',
            ]),
            $this->data([
                'name' => 'Puji Widodo Sutantio',
                'email' => 'pujiwidodosut@informatics.undip.ac.id',
                'password' => bcrypt('password'),
                'role' => 'head_of_department',
            ]),
            $this->data([
                'name' => 'Singh Khir Khan',
                'email' => 'singkhirkhan@operator.undip.ac.id',
                'password' => bcrypt('password'),
                'role' => 'academic_division',
            ]),
            $this->data([
                'name' => 'John Doe',
                'email' => 'johndoe@lecturer.undip.ac.id',
                'password' => bcrypt('password'),
                'role' => 'lecturer',
            ]),
            $this->data([
                'name' => 'Daffa Fairuz Annizari',
                'email' => 'dafairuz@students.undip.ac.id',
                'password' => bcrypt('password'),
                'role' => 'student',
            ])
        ];

        User::insert($data);
    }
}
