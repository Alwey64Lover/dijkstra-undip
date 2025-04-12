<?php

namespace Database\Seeders;

use App\Models\Department;
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
        $informaticDepartment = Department::where('name', 'Informatika')->first();

        // Lecturers & Students
            $lecturers = [
                $this->data([
                    'name' => 'John Doe',
                    'email' => 'johndoe@lecturer.undip.ac.id',
                    'password' => bcrypt('password'),
                    'role' => 'lecturer',
                    'department_id' => $informaticDepartment->id,
                ]),
                $this->data([
                    'name' => 'Dr.Eng. Adi Wibowo, S.Si., M.Kom.',
                    'email' => 'adiwibowo@lecturer.undip.ac.id',
                    'password' => bcrypt('password'),
                    'role' => 'lecturer',
                    'department_id' => $informaticDepartment->id,
                ]),
                $this->data([
                    'name' => 'Etna Vianita, S.Mat., M.Mat.',
                    'email' => 'etna@lecturer.undip.ac.id',
                    'password' => bcrypt('password'),
                    'role' => 'lecturer',
                    'department_id' => $informaticDepartment->id,
                ]),
                $this->data([
                    'name' => 'Sandy Kurniawan, S.Kom., M.Kom.',
                    'email' => 'sandy@lecturer.undip.ac.id',
                    'password' => bcrypt('password'),
                    'role' => 'lecturer',
                    'department_id' => $informaticDepartment->id,
                ]),
                $this->data([
                    'name' => 'Clement Ponso',
                    'email' => 'clementponso@deans.undip.ac.id',
                    'password' => bcrypt('password'),
                    'role' => 'dean',
                    'department_id' => $informaticDepartment->id,
                ]),
                $this->data([
                    'name' => 'Alfonso Rakabuming Putra Widodo',
                    'email' => 'fufufafa@informatics.undip.ac.id',
                    'password' => bcrypt('password'),
                    'role' => 'head_of_department',
                    'department_id' => $informaticDepartment->id,
                ]),
            ];

            $students = [
                $this->data([
                    'name' => 'Daffa Fairuz Annizari',
                    'email' => 'dafairuz@students.undip.ac.id',
                    'password' => bcrypt('password'),
                    'role' => 'student',
                    'department_id' => $informaticDepartment->id,
                ]),
                $this->data([
                    'name' => 'Faiz Baroqah Maulana',
                    'email' => 'faizbaroqah@students.undip.ac.id',
                    'password' => bcrypt('password'),
                    'role' => 'student',
                    'department_id' => $informaticDepartment->id,
                ]),
                $this->data([
                    'name' => 'Doni Fahrezi',
                    'email' => 'donifahrezi@students.undip.ac.id',
                    'password' => bcrypt('password'),
                    'role' => 'student',
                    'department_id' => $informaticDepartment->id,
                ]),
                $this->data([
                    'name' => 'John Panjaitan',
                    'email' => 'jpanjaitan@students.undip.ac.id',
                    'password' => bcrypt('password'),
                    'role' => 'student',
                    'department_id' => $informaticDepartment->id,
                ]),
                $this->data([
                    'name' => 'Fonz Mitika Gloria',
                    'email' => 'fonzgaming@students.undip.ac.id',
                    'password' => bcrypt('password'),
                    'role' => 'student',
                    'department_id' => $informaticDepartment->id,
                ]),
                $this->data([
                    'name' => 'Ui Ui Alhakim',
                    'email' => 'uiui@students.undip.ac.id',
                    'password' => bcrypt('password'),
                    'role' => 'student',
                    'department_id' => $informaticDepartment->id,
                ]),
                $this->data([
                    'name' => 'Ican Cobain',
                    'email' => 'icobain@students.undip.ac.id',
                    'password' => bcrypt('password'),
                    'role' => 'student',
                    'department_id' => $informaticDepartment->id,
                ]),
                $this->data([
                    'name' => 'Elite Barbarian',
                    'email' => 'midladder@students.undip.ac.id',
                    'password' => bcrypt('password'),
                    'role' => 'student',
                    'department_id' => $informaticDepartment->id,
                ]),
                $this->data([
                    'name' => 'Reyna Aldi',
                    'email' => 'reynopradipto@students.undip.ac.id',
                    'password' => bcrypt('password'),
                    'role' => 'student',
                    'department_id' => $informaticDepartment->id,
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
                    'academic_advisor_id' => $lecturerDetails[0]['id'],
                    'nim' => '24060122140044',
                    'year' => 2022,
                ]),
                $this->data([
                    'user_id' => $students[1]['id'],
                    'academic_advisor_id' => $lecturerDetails[0]['id'],
                    'nim' => '24060121130044',
                    'year' => 2021,
                ]),
                $this->data([
                    'user_id' => $students[2]['id'],
                    'academic_advisor_id' => $lecturerDetails[0]['id'],
                    'nim' => '24060122140104',
                    'year' => 2022,
                ]),
                $this->data([
                    'user_id' => $students[3]['id'],
                    'academic_advisor_id' => $lecturerDetails[0]['id'],
                    'nim' => '24060122120001',
                    'year' => 2022,
                ]),
                $this->data([
                    'user_id' => $students[4]['id'],
                    'academic_advisor_id' => $lecturerDetails[0]['id'],
                    'nim' => '24060122120002',
                    'year' => 2022,
                ]),
                $this->data([
                    'user_id' => $students[5]['id'],
                    'academic_advisor_id' => $lecturerDetails[0]['id'],
                    'nim' => '24060122120003',
                    'year' => 2022,
                ]),
                $this->data([
                    'user_id' => $students[6]['id'],
                    'academic_advisor_id' => $lecturerDetails[0]['id'],
                    'nim' => '24060122120004',
                    'year' => 2022,
                ]),
                $this->data([
                    'user_id' => $students[7]['id'],
                    'academic_advisor_id' => $lecturerDetails[0]['id'],
                    'nim' => '24060122120005',
                    'year' => 2022,
                ]),
                $this->data([
                    'user_id' => $students[8]['id'],
                    'academic_advisor_id' => $lecturerDetails[0]['id'],
                    'nim' => '24060122120006',
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
                    'department_id' => null,
                ]),
                $this->data([
                    'name' => 'Singh Khir Khan',
                    'email' => 'singkhirkhan@academic.undip.ac.id',
                    'password' => bcrypt('password'),
                    'role' => 'academic_division',
                    'department_id' => null,
                ]),
            ];

            $users = array_merge($users, $lecturers, $students);

        // Insert
            User::insert($users);
            Lecturer::insert($lecturerDetails);
            Student::insert($studentDetails);

    }
}
