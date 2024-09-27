<?php

namespace Database\Seeders;

use App\Models\Lecturer;
use App\Models\Student;
use App\Models\User;

class UserSeeder extends DatabaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lecturers & Students
            $lecturers = [
                $this->data([
                    'name' => 'John Doe',
                    'email' => 'johndoe@lecturer.undip.ac.id',
                    'password' => bcrypt('password'),
                    'role' => 'lecturer',
                ]),
                $this->data([
                    'name' => 'Dr.Eng. Adi Wibowo, S.Si., M.Kom.',
                    'email' => 'adiwibowo@lecturer.undip.ac.id',
                    'password' => bcrypt('password'),
                    'role' => 'lecturer',
                ]),
                $this->data([
                    'name' => 'Etna Vianita, S.Mat., M.Mat.',
                    'email' => 'etna@lecturer.undip.ac.id',
                    'password' => bcrypt('password'),
                    'role' => 'lecturer',
                ]),
                $this->data([
                    'name' => 'Sandy Kurniawan, S.Kom., M.Kom.',
                    'email' => 'sandy@lecturer.undip.ac.id',
                    'password' => bcrypt('password'),
                    'role' => 'lecturer',
                ]),
                $this->data([
                    'name' => 'Clement Ponso',
                    'email' => 'clementponso@deans.undip.ac.id',
                    'password' => bcrypt('password'),
                    'role' => 'dean',
                ]),
                $this->data([
                    'name' => 'Alfonso Rakabuming Putra Widodo',
                    'email' => 'fufufafa@informatics.undip.ac.id',
                    'password' => bcrypt('password'),
                    'role' => 'head_of_department',
                ]),
            ];

            $students = [
                $this->data([
                    'name' => 'Daffa Fairuz Annizari',
                    'email' => 'dafairuz@students.undip.ac.id',
                    'password' => bcrypt('password'),
                    'role' => 'student',
                ]),
                $this->data([
                    'name' => 'I love life',
                    'email' => 'ilovelife@students.undip.ac.id',
                    'password' => bcrypt('password'),
                    'role' => 'student',
                ]),
                $this->data([
                    'name' => 'I love everything',
                    'email' => 'iloveeverything@students.undip.ac.id',
                    'password' => bcrypt('password'),
                    'role' => 'student',
                ]),
            ];

        // Lecturer & Student Details
            $lecturerDetails = [
                $this->data([
                    'user_id' => $lecturers[0]['id'],
                    'nip' => '198203092006041001',
                    'nidn' => null,
                ]),
                $this->data([
                    'user_id' => $lecturers[1]['id'],
                    'nip' => '198203092006041002',
                    'nidn' => '0001047404',
                ]),
                $this->data([
                    'user_id' => $lecturers[2]['id'],
                    'nip' => '197404011999031003',
                    'nidn' => null,
                ]),
                $this->data([
                    'user_id' => $lecturers[3]['id'],
                    'nip' => '197404011999031003',
                    'nidn' => '0001047405',
                ]),
                $this->data([
                    'user_id' => $lecturers[4]['id'],
                    'nip' => '197404011999031003',
                    'nidn' => '0001047406',
                ]),
                $this->data([
                    'user_id' => $lecturers[5]['id'],
                    'nip' => '197404011999031003',
                    'nidn' => '0001047407',
                ])
            ];

            $studentDetails = [
                $this->data([
                    'user_id' => $students[0]['id'],
                    'academic_advisor_id' => $lecturerDetails[3]['id'],
                    'nim' => '24060122140044',
                    'year' => 2022,
                ]),
                $this->data([
                    'user_id' => $students[1]['id'],
                    'academic_advisor_id' => $lecturerDetails[1]['id'],
                    'nim' => '24060121130044',
                    'year' => 2021,
                ]),
                $this->data([
                    'user_id' => $students[2]['id'],
                    'academic_advisor_id' => $lecturerDetails[2]['id'],
                    'nim' => '24060122140104',
                    'year' => 2022,
                ])
            ];

        // Users & Merge
            $users = [
                $this->data([
                    'name' => 'Admin',
                    'email' => 'admin@gmail.com',
                    'password' => bcrypt('password'),
                    'role' => 'superadmin',
                ]),
                $this->data([
                    'name' => 'Singh Khir Khan',
                    'email' => 'singkhirkhan@operator.undip.ac.id',
                    'password' => bcrypt('password'),
                    'role' => 'academic_division',
                ]),
            ];

            $users = array_merge($users, $lecturers, $students);

        // Insert
            User::insert($users);
            Lecturer::insert($lecturerDetails);
            Student::insert($studentDetails);

    }
}
