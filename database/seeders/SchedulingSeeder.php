<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Course;
use App\Models\CourseClass;
use App\Models\CourseDepartment;
use App\Models\CourseDepartmentDetail;
use App\Models\Department;
use App\Models\Lecturer;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchedulingSeeder extends DatabaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academicYear = AcademicYear::all();
        $rooms = Room::all();
        $informaticsDepartment = Department::where('name', 'Informatika')->first();
        $users = User::where('role', 'academic_division')->get();
        $lecturers = Lecturer::all();

        // room
            // Room ku pindah di RoomSeeder.php - Fons

        // course
            $courses = [
                $this->data([
                    'code' => 'PAIK0080',
                    'name' => 'Dasar Pemrograman',
                ]),
                $this->data([
                    'code' => 'KIAP0140',
                    'name' => 'Matematika I',
                ]),
                $this->data([
                    'code' => 'PAIK6406',
                    'name' => 'Sistem Cerdas',
                ]),
                $this->data([
                    'code' => 'PAIK6404',
                    'name' => 'Grafika dan Komputasi Visual',
                ]),
                $this->data([
                    'code' => 'PAIK6401',
                    'name' => 'Pemrograman Berorientasi Objek',
                ]),
                $this->data([
                    'code' => 'PAIK6403',
                    'name' => 'Manajemen Basis Data',
                ]),
                $this->data([
                    'code' => 'PAIK6601',
                    'name' => 'Analisis dan Strategi Algoritma',
                ]),
                $this->data([
                    'code' => 'PAIK6405',
                    'name' => 'Rekayasa Perangkat Lunak',
                ]),
            ];

        // Course Department
            $courseDepartments = $academicYear->map(function($year) use ($informaticsDepartment, $users) {
                return $this->data([
                    'department_id' => $informaticsDepartment->id,
                    'academic_year_id' => $year->id,
                    'action_name' => $year->name === '2024/2025 Genap' ? CourseDepartment::ACTIONS[0] : CourseDepartment::ACTIONS[1],
                    'is_submitted'=> $year->name === '2024/2025 Genap' ? false : true,
                    'action_at' => now(),
                    'action_by_id' => $users->random()->id,
                ]);
            })->toArray();



            $courseDepartmentDetails = [
                $this->data([
                    'course_department_id' => $courseDepartments[4]['id'],
                    'course_id' => $courses[0]['id'],
                    'lecturer_ids' => json_encode(collect($lecturers)->pluck('id')->take(rand(0, count($lecturers)))->toArray()),
                    'status' => randomArray(array_keys(CourseDepartmentDetail::STATUSES)),
                    'semester' => rand(1, 14),
                    'sks' => rand(1, 4),
                    'max_student' => rand(40, 60),
                ]),
                $this->data([
                    'course_department_id' => $courseDepartments[4]['id'],
                    'course_id' => $courses[1]['id'],
                    'lecturer_ids' => json_encode(collect($lecturers)->pluck('id')->take(rand(0, count($lecturers)))->toArray()),
                    'status' => randomArray(array_keys(CourseDepartmentDetail::STATUSES)),
                    'semester' => rand(1, 14),
                    'sks' => rand(1, 4),
                    'max_student' => rand(40, 60),
                ]),
            ];

            $courseClasses = [
                $this->data([
                    'room_id' => $rooms[3]['id'],
                    'course_department_detail_id' =>$courseDepartmentDetails[0]['id'],
                    'name' => 'A',
                    'day' => CourseClass::DAYS[0],
                    'start_time' => '07:00',
                    'end_time' => '09:30',
                ]),
                $this->data([
                    'room_id' => $rooms[4]['id'],
                    'course_department_detail_id' => $courseDepartmentDetails[1]['id'],
                    'name' => 'D',
                    'day' => CourseClass::DAYS[3],
                    'start_time' => '13:00',
                    'end_time' => '15:30',
                ]),
            ];

        // Insert data
            Course::insert($courses);
            CourseDepartment::insert($courseDepartments);
            CourseDepartmentDetail::insert($courseDepartmentDetails);
            CourseClass::insert($courseClasses);
    }
}
